#!/bin/bash

PDF_SOURCE="original.pdf"
PDF_DEST="last.pdf"
OUTDIR="media"
CLEANED="signatures"

mkdir -p "$OUTDIR" "$CLEANED"

if [ ! -f "$PDF_SOURCE" ]; then
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

# Nettoyage, inversion et filtrage via Python
python3 <<EOF
from pathlib import Path
from PIL import Image, ImageOps

TARGET_WIDTH = 996
TARGET_HEIGHT = 750

input_dir = Path("$OUTDIR")
output_dir = Path("$CLEANED")
output_dir.mkdir(exist_ok=True)

def is_blank(image, threshold=0.98):
    gray = image.convert("L")
    histogram = gray.histogram()
    total_pixels = sum(histogram)
    white_pixels = histogram[255]
    ratio = white_pixels / total_pixels
    return ratio >= threshold

index = 1
for img_path in sorted(input_dir.glob("*.png")):
    img = Image.open(img_path).convert("RGB")

    # Filtre par dimensions exactes
    if img.width != TARGET_WIDTH or img.height != TARGET_HEIGHT:
        continue

    inverted = ImageOps.invert(img)

    if is_blank(inverted):
        continue

    output_path = output_dir / f"{index}.png"
    inverted.save(output_path)
    index += 1
EOF
