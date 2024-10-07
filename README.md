# Free Plesk Activator

Welcome, Plesk Users! The primary objective of this project is to facilitate the management of multiple servers using an existing license. This solution is entirely open-source and is devoid of any advertisements. Feel free to seamlessly integrate it into your server environment to activate your Plesk instance. As an avid Plesk Panel user myself, I am committed to providing continuous updates to the license file. In the rare event of oversight on my part, please don't hesitate to reach out to me via email. It's worth noting that this solution refrains from adding cron jobs to your server or running in the background, ensuring its reliability.

## Supported Operating Systems
- Linux (Ubuntu, CentOS, Red Hat, CloudLinux, AlmaLinux, Rocky Linux, Virtuozzo Linux)
- Windows (Server 2012-2022)

## How to Use

To utilize this activator, follow these simple steps:

1. Download the activator script:
   ```bash
   wget -O freePleskActivator.php --no-check-certificate https://raw.githubusercontent.com/technomango/PleskActivator/refs/heads/main/freePleskActivator.php
   ```

2. Execute the script using Plesk PHP:
   ```bash
   plesk php freePleskActivator.php
   ```


## Automatic Execution
To automatically execute it, follow these steps:

Url: admin/scheduler/tasks-list
![admin/scheduler/tasks-list](https://i.imgur.com/rP8toq0.png)

1. Add the code:
   ```bash
   wget -O freePleskActivator.php --no-check-certificate https://raw.githubusercontent.com/xMajdev/freePleskActivator/main/freePleskActivator.php && /opt/psa/admin/bin/php 'freePleskActivator.php'
   ```

## License Info
```
Key Info:
Edition Name: web host edition
Plesk Key ID: PLSK112541280000
License Expiry Date: 2024-07-24
```
