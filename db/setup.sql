CREATE TABLE `users` (
	`username` TEXT NOT NULL,
	`passkey`	TEXT NOT NULL,
	`name`	TEXT NOT NULL,
	PRIMARY KEY(username)
);

CREATE TABLE `activity` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`owner`	TEXT NOT NULL,
	`ts`	INTEGER NOT NULL,
	`activity_name`	INTEGER NOT NULL,
	`distance`	INTEGER NOT NULL,
	`duration`	INTEGER NOT NULL,
	`rating`	INTEGER NOT NULL DEFAULT "3"
);

CREATE TABLE `trackPoint` (
	`activity`	INTEGER NOT NULL,
	`ts`	INTEGER NOT NULL,
	`lat`	REAL NOT NULL,
	`lon`	REAL NOT NULL,
	`sigma`	INTEGER NOT NULL,
	`duration`	INTEGER NOT NULL,
	`distance`	INTEGER NOT NULL
);
