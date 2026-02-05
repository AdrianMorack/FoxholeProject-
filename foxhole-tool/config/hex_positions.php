<?php

/**
 * Hex positions on the world map
 * Each hex has normalized x, y position (0-1) and width/height (0-1) on the world map
 * You need to manually measure these from your FoxholeMap.png
 */
return [
    'DeadLandsHex' => [
        'x' => 0.3,      // Left edge position (0-1)
        'y' => 0.4,      // Top edge position (0-1)
        'width' => 0.08, // Width as fraction of map (0-1)
        'height' => 0.08, // Height as fraction of map (0-1)
    ],
    'HeartlandsHex' => [
        'x' => 0.5,
        'y' => 0.5,
        'width' => 0.08,
        'height' => 0.08,
    ],
    // Add all 42 hexes with their positions...
    // You'd measure these from your world map image
];
