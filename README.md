# PassViewer_v1.0
A self-hosted web application to securely view and manage credentials for media, finance, and network accounts. Being able to access credentials without the need of third-party software.


Before run the app make sure give access read & write to this 2 directories

* Only need to do this for Linux OS *

1.  /database/main => Give all user (Create and Delete Files) permission
2.  /priority => Give all user (Create and Delete Files) permission
3.  /database/main/PassViewer.db => Give all user (Read and Write) permission

4. If using Apache2. Run "sudo nano /etc/apache2/apache2.conf"

Make sure in there set as below :

// Indexes will allow browser file explorer

<Directory /var/www>
        Options <Indexes will added here> FollowSymLinks
        AllowOverride None
        Require all granted
</Directory>

<Directory "/var/www/html/PassViewer/priority">
    <Files "Codes.pdf">
        Options
        Require all denied
    </Files>
</Directory>

5. Run "sudo systemctl restart apache2"

