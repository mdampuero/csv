## Server
```bash
sudo apt-get update
sudo apt-get install net-tools
ifconfig
sudo apt-get install samba
ssh-keygen -t rsa -b 4096 -C "mdampuero@gmail.com"
eval "$(ssh-agent -s)"
ssh-add ~/.ssh/id_rsa
cat ~/.ssh/id_rsa.pub
git clone git@github.com:mdampuero/orquideatech.git
cd orquideatech/
sudo apt  install docker.io
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
sudo usermod -aG docker $USER
sudo nano /etc/samba/smb.conf
[Public]
   comment = Carpeta Pública
   path = /home/ubuntu/orquideatech
   browseable = yes
   read only = no
   guest ok = yes
```


## Install

```bash
./install.sh
```

## Test

```bash
docker exec -ti app-php composer test test/
```
