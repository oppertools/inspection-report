<?php

namespace App\Domain\InspectionReports\Services;

use App\Domain\InspectionReports\Data\Room\Color;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class ColorNameResolverService
{
    protected array $colors;

    protected string $file;

    public function __construct()
    {
        $this->file = storage_path('app/colors.json');

        if (! file_exists($this->file)) {
            file_put_contents($this->file, '{}');
        }

        $this->colors = json_decode(file_get_contents($this->file), true);
    }

    public function resolve(string $input): ?Color
    {
        foreach ($this->colors as $standardName => $hex) {
            if (mb_strtolower($input) === mb_strtolower($standardName)) {
                return new Color($standardName, $hex);
            }
        }

        $result = $this->getColor($input);

        if ($result && isset($result['name'], $result['hex'])) {
            $key = mb_strtolower($result['name']);
            $this->colors[$key] = $result['hex'];
            file_put_contents($this->file, json_encode($this->colors, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            return new Color($result['name'], $result['hex']);
        }

        return null;
    }

    protected function getColor(string $color): ?array
    {
        $localColor = $this->findColorInLocalLibrary($color);

        if (! $localColor) {
            /*
            $result = $this->getObjectColor($color);

            $standardizedColor = $this->findColorInLocalLibrary($result->name);

            if ($standardizedColor) {
                return $standardizedColor;
            }

            if ($result->hex) {
                $key = mb_strtolower($result->name);
                $this->colors[$key] = $result->hex;
                file_put_contents($this->file, json_encode($this->colors, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                return [
                    'name' => $result->name,
                    'hex' => $result->hex
                ];
            }*/

            return $localColor;
        }

        return $localColor;
    }

    protected function getObjectColor(string $color): object
    {
        $prompt = <<<EOT
Tu es un assistant expert en standardisation de noms de couleurs en français, et en génération de codes hexadécimaux issus de la palette Material Design.

Ta tâche est de :

Standardiser un nom de couleur donné, même s’il est mal orthographié ou imprécis (ex. "blan", "nwar", "vert anis").

Renvoyer un objet JSON contenant :

"name" : le nom standardisé, avec une majuscule initiale, en français, et toujours au singulier.

"hex" : un code hexadécimal clair (pas trop foncé) choisi uniquement dans la palette Material Design.

Exemples de standardisation :
"blanche", "blan" → "Blanc"

"Brun", "Brun foncé", "Brun clair" doivent être 3 noms différents.

"nwar", "noire" → "Noir"

"vert bouteille", "vert d’eau" → "Vert"

Format de sortie obligatoire :
Toujours renvoyer uniquement un objet JSON de la forme suivante :
{"name": "Rouge", "hex": "#F44336"}

Si le nom ne peut pas être reconnu ou standardisé, retourne :
{"name": "valeur_originale", "hex": null}

La réponse doit TOUJOURS être un objet JSON. Aucune explication ni texte supplémentaire.

Entrée :
Nom de la couleur à standardiser : {$color}
EOT;

        $attempts = 0;
        $maxAttempts = 3;

        while ($attempts < $maxAttempts) {
            try {
                $response = OpenAI::chat()->create([
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'temperature' => 0.2,
                ]);

                $content = $response['choices'][0]['message']['content'] ?? null;

                if ($content) {
                    $decoded = json_decode($content);

                    if (json_last_error() === JSON_ERROR_NONE && is_object($decoded)) {
                        return $decoded;
                    } else {
                        return json_decode($content);
                    }
                }

                return json_decode('{"name": "'.$color.'", "hex": null}');

            } catch (\Exception $e) {
                $attempts++;
                if ($attempts >= $maxAttempts) {
                    Log::error("Impossible de standardiser la couleur après {$maxAttempts} tentatives: ".$e->getMessage());

                    return json_decode('{"name": "'.$color.'", "hex": null}');
                }

                sleep(pow(2, $attempts));
            }
        }

        $fallback = new \stdClass;
        $fallback->name = $color;
        $fallback->hex = null;

        return $fallback;
    }

    protected function findColorInLocalLibrary(string $value): ?array
    {
        $normalizedValue = mb_strtolower($value);

        foreach ($this->colors as $standardName => $hex) {
            if (mb_strtolower($standardName) === $normalizedValue) {
                return [
                    'name' => $standardName,
                    'hex' => $hex,
                ];
            }
        }

        return null;
    }
}
