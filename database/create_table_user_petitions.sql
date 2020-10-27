CREATE TABLE user_petitions(
  id INT,
  user_id INT,
  petition_id INT,
  date DATE,
  firstName VARCHAR(60),
  lastName VARCHAR(60),
  email VARCHAR(255),
  country VARCHAR(90),
  city VARCHAR(90),
  reason VARCHAR(255),
  public VARCHAR(255),
  token VARCHAR(255),
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES user(id),
  FOREIGN KEY (petition_id) REFERENCES petitions(id)
);
