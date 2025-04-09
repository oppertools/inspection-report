<?php

namespace App\Domain\InspectionReports\Enums\Room;

enum RoomType: string
{
    case ENTRANCE = 'entrance';
    case TOILET = 'toilet';
    case BATHROOM = 'bathroom';
    case LIVING_ROOM = 'living_room';
    case KITCHEN = 'kitchen';
    case BEDROOM = 'bedroom';
    case BALCONY = 'balcony';
    case TERRASSE = 'terrasse';
    case CELLAR = 'cellar';
    case CARPARK = 'carpark';
    case BOX = 'box';
    case GARAGE = 'garage';
    case GARDEN = 'garden';
    case LAUNDRY_ROOM = 'laundry_room';
    case PRIVATE_OFFICE = 'private_office';
    case OPEN_SPACE = 'open_space';
    case MEETING_ROOM = 'meeting_room';
    case PHONE_BOOTH = 'phone_booth';
    case HALL = 'hall';
    case SHARED_AREAS = 'shared_areas';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::ENTRANCE => 'Entrée',
            self::TOILET => 'Toilettes',
            self::BATHROOM => 'Salle de bain',
            self::LIVING_ROOM => 'Salon',
            self::KITCHEN => 'Cuisine',
            self::BEDROOM => 'Chambre',
            self::BALCONY => 'Balcon',
            self::TERRASSE => 'Terrasse',
            self::CELLAR => 'Cave',
            self::CARPARK => 'Parking',
            self::BOX => 'Box',
            self::GARAGE => 'Garage',
            self::GARDEN => 'Jardin',
            self::LAUNDRY_ROOM => 'Buanderie',
            self::PRIVATE_OFFICE => 'Bureau privé',
            self::OPEN_SPACE => 'Open space',
            self::MEETING_ROOM => 'Salle de réunion',
            self::PHONE_BOOTH => 'Cabine téléphonique',
            self::HALL => 'Hall',
            self::SHARED_AREAS => 'Parties communes',
            self::OTHER => 'Autre',
        };
    }
}
