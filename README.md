# Quizzy (spell Квіззі)

Students assessment system.

## Installation

Copy env:

```shell
cp .env.example .env
```

Start docker:

```shell
cd docker
cp .env.example .env
docker compose up -d
```

Run set up script (database migrations, data seeder):

```shell
docker compose exec php bash # connect to the container
cd docker/services/php/ 
bash ./dev-setup.sh # run setup script
```

Finally, if there were no errors, you should be able to open http://localhost:8077/ and see the web-site.

> If you use other port than 8077, check it out with `docker compose ps` 

## Branches

`main` - The one you should deploy the production from.
`dev` - Development branch, merge your features here.

Once you are ready to deploy into production, merge `dev` into `main` and run the deployment.

## Portals

### Main portal

This is the one students pass their tests at.
Locally, available at http://localhost:8077/

### Nova admin portal

Main administrator's portal.
Available at: http://localhost:8077/nova/login

### Old admin portal

This portal had been used before nova admin was introduced.
Available at: http://localhost:8077/old-admin

## Deployment

You can see the deployment script at `deploy/deploy.php`.

### Remote server ssh configuration

Configure ssh connection to the server `nano ~/.ssh/config`:

```txt
Host hpk_test
    HostName <server_host>
    IdentityFile ~/.ssh/id_rsa
    User <ssh_user>
```

Where `<server_host>` is the ip of the production server.
And `<ssh_user>` - ssh user you want to ssh with.

### Git remote

Add git remote for the production server:

```shell
git remote add production hpk_test:/home/hpktest/repo/app.git
```

### Server .env configuration

You should connect to the server and configure proper environment for it.

```shell
git push production main
ssh hpk_test
cd ~/app/
# you can either nano the file, or modify it locally and then push it with scp from terminal or via filezilla ui client
nano .env
```

### Run the deployment

In order to deploy the application, push the code to your production server, and then run deploy.php script.

```shell
git push production main
ssh hpk_test
cd ~/app/deploy/
chmod +x deploy.php
./deploy.php
```

> If you wish, you could configure git `post-receive` hook on the server and run the deployment script automatically.
