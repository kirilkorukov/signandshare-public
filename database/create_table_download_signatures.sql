CREATE TABLE download_signatures_requests(
  id INT AUTO_INCREMENT,
  petition_id INT,
  user_email VARCHAR(255),
  user_id INT,
  letter TEXT,
  date DATE,
  format VARCHAR(255),
  PRIMARY KEY (id),
  FOREIGN KEY (petition_id) REFERENCES petition(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);
