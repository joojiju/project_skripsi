<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Tersedia()
 * @method static static SudahDiBooking()
 * @method static static SedangDigunakan()
 * @method static static Rusak()
 */
final class InventoryStatus extends Enum
{
    const Tersedia =        0;
    const SudahDibooking =  1;
    const SedangDigunakan = 2;
    const Rusak =           3;
}
