CREATE TABLE petition(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  byWho VARCHAR(255) NOT NULL,
  target VARCHAR(255) NOT NULL,
  currentSupporters INT NOT NULL,
  goalSupporters INT NOT NULL,
  date VARCHAR(255) NOT NULL,
  overview TEXT NOT NULL,
  image VARCHAR(255),
  category VARCHAR(255),
  user_id INT NOT NULL,
  path VARCHAR(255),
  featured INT DEFAULT 1,
  victory INT,
  closed INT,
  letter TEXT,
  lastUpdate DATE
)
