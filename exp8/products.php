<?php
$products = [
  [
    "sys" => ["id" => "1"],
    "fields" => [
      "name" => "Buttermilk Pancakes",
      "desc" => "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Velit, temporibus.",
      "price" => 15.99,
      "category" => "breakfast",
      "img" => ["fields" => ["file" => ["url" => "./images/buttermilk pancakes.jpeg"]]]
    ]
  ],
  [
    "sys" => ["id" => "2"],
    "fields" => [
      "name" => "Dinner Double",
      "desc" => "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Animi velit temporibus ab?",
      "price" => 13.99,
      "category" => "dinner",
      "img" => ["fields" => ["file" => ["url" => "./images/double meal.jpeg"]]]
    ]
  ],
  [
    "sys" => ["id" => "3"],
    "fields" => [
      "name" => "Godzilla Milkshake",
      "desc" => "Lorem ipsum dolor sit amet consectetur adipisicing elit.",
      "price" => 6.99,
      "category" => "shakes",
      "img" => ["fields" => ["file" => ["url" => "./images/godzilla milkshake.jpg"]]]
    ]
  ],
  [
    "sys" => ["id" => "4"],
    "fields" => [
      "name" => "Country Delight",
      "desc" => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magnam vitae necessitatibus quia eum quasi culpa!",
      "price" => 20.99,
      "category" => "lunch",
      "img" => ["fields" => ["file" => ["url" => "./images/half boiled omelette.jpg"]]]
    ]
  ],
  [
    "sys" => ["id" => "5"],
    "fields" => [
      "name" => "Oreo Dream",
      "desc" => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Debitis, fugit ad.",
      "price" => 18.99,
      "category" => "shakes",
      "img" => ["fields" => ["file" => ["url" => "./images/oreo milkshake.jpeg"]]]
    ]
  ],
  [
    "sys" => ["id" => "6"],
    "fields" => [
      "name" => "Quarantime Buddy",
      "desc" => "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Libero incidunt iste, cum distinctio iure quaerat autem!",
      "price" => 16.99,
      "category" => "shakes",
      "img" => ["fields" => ["file" => ["url" => "./images/quarantime buddy.png"]]]
    ]
  ]
];

header('Content-Type: application/json');
echo json_encode(["items" => $products]);
