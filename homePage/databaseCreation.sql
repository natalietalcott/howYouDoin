CREATE TABLE IF NOT EXISTS USER_ACCOUNT
(
    email VARCHAR (50) NOT NULL,
    password VARCHAR (50) NOT NULL,
    PRIMARY KEY (email)
);
CREATE TABLE IF NOT EXISTS DAILY_LOG
(
    email VARCHAR (50) NOT NULL,
    date VARCHAR (30),
    emotion VARCHAR (30),
    emoticon VARCHAR (30),
    note VARCHAR (280),
    PRIMARY KEY (email,date)
);