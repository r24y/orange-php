CREATE TABLE `passkeys` (
	`passkeys`	TEXT NOT NULL,
	`name`	TEXT NOT NULL,
	PRIMARY KEY(passkeys)
);

CREATE TABLE `run` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`owner_passkey`	TEXT NOT NULL,
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
	`sigma`	INTEGER NOT NULL
);
