<?php
try {
  $db = new SQLite3('projetodb.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

  // Create tables
  $db->query(
    'CREATE TABLE IF NOT EXISTS "ad" (
      "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
      "description" TEXT,
      "model_id" INTEGER,
      "created_at" TEXT,
      FOREIGN KEY (model_id) REFERENCES model(id)
    )'
  );

  $db->query(
    'CREATE TABLE IF NOT EXISTS "brand" (
      "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
      "description" TEXT
    )'
  );

  $db->query(
    'CREATE TABLE IF NOT EXISTS "model" (
      "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
      "description" TEXT,
      "brand_id" INTEGER,       
      FOREIGN KEY (brand_id) REFERENCES brand(id)
    )'
  );

  //Adding brands and models to the database
  $db->query('INSERT INTO "brand" ("description") VALUES ("ford")');
  $db->query('INSERT INTO "brand" ("description") VALUES ("fiat")');
  $db->query('INSERT INTO "brand" ("description") VALUES ("peugeot")');
  $db->query('INSERT INTO "brand" ("description") VALUES ("toyota")');

  $db->query('INSERT INTO "model" ("description", "brand_id") VALUES ("ecosport", 1)');
  $db->query('INSERT INTO "model" ("description", "brand_id") VALUES ("ka", 1)');
  $db->query('INSERT INTO "model" ("description", "brand_id") VALUES ("mustang", 1)');

  $db->query('INSERT INTO "model" ("description", "brand_id") VALUES ("argo", 2)');
  $db->query('INSERT INTO "model" ("description", "brand_id") VALUES ("idea", 2)');
  $db->query('INSERT INTO "model" ("description", "brand_id") VALUES ("siena", 2)');

  $db->query('INSERT INTO "model" ("description", "brand_id") VALUES ("208", 3)');
  $db->query('INSERT INTO "model" ("description", "brand_id") VALUES ("408", 3)');
  $db->query('INSERT INTO "model" ("description", "brand_id") VALUES ("207", 3)');

  $db->query('INSERT INTO "model" ("description", "brand_id") VALUES ("yaris", 4)');
  $db->query('INSERT INTO "model" ("description", "brand_id") VALUES ("corolla", 4)');
  $db->query('INSERT INTO "model" ("description", "brand_id") VALUES ("hilux", 4)');

  // Get a count of the number of brands
  $brandCount = $db->querySingle('SELECT COUNT(DISTINCT "id") FROM "brand"');
  echo ("Brand count: $brandCount\n");

  // Get a count of the number of brands
  $modelCount = $db->querySingle('SELECT COUNT(DISTINCT "id") FROM "model"');
  echo ("Model count: $modelCount\n");

  // Get a count of the number of brands
  $adCount = $db->querySingle('SELECT COUNT(DISTINCT "id") FROM "ad"');
  echo ("Ad count: $adCount\n");

  // Close the connection
  $db->close();
} catch (Exception $exception) {
  echo $exception->getMessage();
}
