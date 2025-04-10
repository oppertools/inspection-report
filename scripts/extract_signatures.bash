#!/bin/bash

PDF_SOURCE="original.pdf"
PDF_DEST="last.pdf"
OUTDIR="media"
CLEANED="signatures"

mkdir -p "$OUTDIR" "$CLEANED"

if [ ! -f "$PDF_SOURCE" ]; then
    echo "Fichier introuvable : $PDF_SOURCE"
    exit 1
fi

# Récupération du nombre total de pages
TOTAL_PAGES=$(pdfinfo "$PDF_SOURCE" | grep "Pages" | awk '{print $2}')

# Extraction des deux dernières pages
if [ "$TOTAL_PAGES" -ge 2 ]; then
    START_PAGE=$((TOTAL_PAGES - 1))
    pdftk "$PDF_SOURCE" cat $START_PAGE-$TOTAL_PAGES output "$PDF_DEST"
else
    pdftk "$PDF_SOURCE" cat 1 output "$PDF_DEST"
fi

# Extraction des images en PNG
pdfimages -png "$PDF_DEST" "$OUTDIR/signature"

# Traitement des images : inversion, filtrage, nettoyage, renommage
python3 <<EOF
from pathlib import Path
from PIL import Image, ImageOps

TARGET_WIDTH = 996
TARGET_HEIGHT = 750
THRESHOLD = 0.98

input_dir = Path("$OUTDIR")
output_dir = Path("$CLEANED")
output_dir.mkdir(exist_ok=True)

def is_blank(image):
    gray = image.convert("L")
    inverted = ImageOps.invert(gray)
    histogram = inverted.histogram()
    white_pixels = histogram[255]
    return white_pixels / sum(histogram) >= THRESHOLD

def is_fully_white(image):
    gray = image.convert("L")
    histogram = gray.histogram()
    return histogram[255] == sum(histogram)

valid_images = []

# Étape 1 : filtrage et inversion
for img_path in sorted(input_dir.glob("*.png")):
    img = Image.open(img_path).convert("RGB")

    if img.width != TARGET_WIDTH or img.height != TARGET_HEIGHT:
        continue

    inverted = ImageOps.invert(img)
    if is_blank(inverted):
        continue

    valid_images.append(inverted)

# Étape 2 : suppression des images 100 % blanches (post inversion)
non_white_images = []
for img in valid_images:
    if not is_fully_white(img):
        non_white_images.append(img)

# Étape 3 : renommage séquentiel
for i, img in enumerate(non_white_images, start=1):
    output_path = output_dir / f"{i}.png"
    img.save(output_path)
EOF
