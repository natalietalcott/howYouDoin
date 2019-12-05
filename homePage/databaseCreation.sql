CREATE TABLE IF NOT EXISTS USER_ACCOUNT (
    email VARCHAR (50) NOT NULL,
    password VARCHAR (50) NOT NULL,
    activated BOOLEAN NOT NULL DEFAULT false,
    PRIMARY KEY (email)
);

CREATE TABLE IF NOT EXISTS DAILY_LOG (
    email VARCHAR (50) NOT NULL,
    date VARCHAR (30),
    emotion VARCHAR (30),
    note VARCHAR (280),
    tag VARCHAR (30),
    PRIMARY KEY (email, date)
);