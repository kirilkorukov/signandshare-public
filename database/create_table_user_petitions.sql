CREATE TABLE user_petitions(
  id INT PRIMARY KEY,
  user_id INT,
  petition_id INT,
  date DATE,
  firstName VARCHAR(255),
  lastName VARCHAR(255),
  email VARCHAR(255),
  country VARCHAR(255),
  city VARCHAR(255),
  reason VARCHAR(255),
  public VARCHAR(255),
  token VARCHAR(255)
)
