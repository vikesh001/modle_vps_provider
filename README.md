# model_vps_provider
## Docker Images for SSH

- **DockerHub Image**: [vikesh001/ubuntu-ssh](https://hub.docker.com/r/vikesh001/ubuntu-ssh)
- **GitHub Repository**: [vikesh001/docker-ubuntu-ssh](https://github.com/vikesh001/docker-ubuntu-ssh)

**Usage:**

```shell
docker run -d -p <host_port>:22 --name <container_name> -e ROOT_PASSWORD=<password> -e USERNAME=<username> vikesh001/ubuntu-ssh
```

**Example:**

```shell
docker run -d -p 1234:22 --name ssh-container -e ROOT_PASSWORD=myrootpass -e USERNAME=myuser vikesh001/ubuntu-ssh
```

## Jump Host to Connect

A jump host server is an intermediary system used to securely access and manage other servers within a network, often employed in situations where direct access to those servers is restricted for security reasons.

**References:**
- [Bard: Secure SSH Jump Host Setup](https://g.co/bard/share/37e03e2df130)

**To Deploy:**

```shell
docker run -d -p 22:22 --name jumphost -e ROOT_PASSWORD=123 -e USERNAME=jumphost vikesh001/ubuntu-ssh
```

- Prepare a .pem key for login: [SSH Login with PEM File](https://nhancv.medium.com/tech-setup-ssh-login-with-pem-file-without-password-on-ubuntu-linux-server-b97dda5a8b8c)
- Block users from accessing the shell: [Bard: Block Shell Access](https://g.co/bard/share/683e2c64132d)

## Deploy Containers for Users

  - Deploy all user containers in a single network.
  - Users can connect to their containers using the jump host server via SSH.
  - Scaling can be done using Docker Swarm.

### Docker Swarm

Docker Swarm is a native clustering and orchestration solution for Docker containers. It allows you to create and manage a swarm of Docker nodes, enabling high availability, load balancing, and scaling of containerized applications across multiple hosts in a simple and integrated manner.

**Why Docker Swarm:**
- Simplifies scaling the VPS providing platform.
- Facilitates easy management.

## Set Up Website (in Docker, put in the same network)

### Apache
1. Enable short tags.
2. Enable SQL injection (sqli) protection.
3. website_v1:[website_code](https://drive.google.com/file/d/1e5caopGOXyu-XkT0WPZzeV2Yf8MqqzjK/view?usp=sharing)
4. github:[github](https://github.com/vikesh001/model_vps_provider)

### MySQL

```shell
docker run --network project --name mysql -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=server -e MYSQL_USER=project123 -e MYSQL_PASSWORD=test@123 -d mysql
```

MySQL Dump File: [Download](https://drive.google.com/file/d/1_RjffVmQb45xG5xNf7etTRGNuGeMEDy4/view?usp=sharing)

### Adminer

```shell
docker run --network project --name adminer --link mysql:mysql -p 8080:8080 -d adminer
```

## API

To be done.
