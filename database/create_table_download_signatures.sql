CREATE TABLE download_signatures_requests(
  id INT AUTO_INCREMENT PRIMARY KEY,
  petition_id INT,
  user_email VARCHAR(255),
  user_id INT,
  letter TEXT,
  date DATE,
  format VARCHAR(255)
);
