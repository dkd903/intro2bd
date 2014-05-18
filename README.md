intro2bd
========

Intro To Big Data Project

This project utilises the IMDB open dataset and has more than 35 Million records. Moviemax is an attempt to implementing an IMDB.com like interface for interacting with the massive database and has a disk-based caching mechanism. There is also an implementation of the Naive Bayesian CLassifier and Collaborative filtering using Euclidean distance. There are no plans to commercialise the project as the IMDB open dataset project license does not allow so.

1. Unzip all the contents of the source zip in a folder inside the 
httpdocs folder of your apache installation
2. Start Apache / MySQL
3. Create database using the included imdb.sql schema file
4. Add your server configurations in config.php file
5. Navigate to the URL you just set in the configuration file
6. Make sure the cache folder has 777 rwx permissions 

Debjit - PHP app, Javascript, caching, classification, recommendation algo implementation
Tejas - Java Part, Android, data cleaning
Sushant, Ashish - Database design, data population, data cleaning
