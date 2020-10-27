CREATE TABLE users(
  id INT AUTO_INCREMENT,
  firstName VARCHAR(255) NOT NULL,
  lastName VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  address VARCHAR(255),
  zip VARCHAR(15),
  city VARCHAR(90),
  state VARCHAR(50),
  country VARCHAR(90),
  phoneNumber VARCHAR(20),
  website VARCHAR(100),
  aboutMe VARCHAR(255),
  emailPreferences VARCHAR(3),
  joined DATE NOT NULL,
  PRIMARY KEY (id)
);
