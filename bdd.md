# Creation bdd
```
sudo docker run -d --name hackathonsMariaDB -e MARIADB_ROOT_PASSWORD=root -e MARIADB_DATABASE=hackathons -e MARIADB_USER=user -e MARIADB_PASSWORD=pwd -v ~/BDD_Hackathon:/var/lib/mysql -p 3308:3306 mariadb:latest
```
