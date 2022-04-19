Readme:
-----------
# Free, open source Project Management software
## Introduction
Orangescrum is the simple yet powerful free and open source project management software that allows teams to organize their tasks, projects and resources with real time project collaboration. Track the task progress and get notifications on their completion with the Orangescrum project management tool. Get the complete picture of all tasks and team activities in real-time. Orangescrum also offers SaaS/Cloud edition and an option to upgrade the community edition to enterprise self-hosted edition.

Orangescrum open-source is a flexible project management web application written using CakePHP.

New features, enhancements, and updates released on a regular basis.

Pull requests and bug reports are always welcome!

Visit our website  [https://www.orangescrum.com/](https://www.orangescrum.com/)  to get a free trial of the premium service.

## Features
Orangescrum provides the rich set features of Project Management.

The key features are:

-Task Management
	Task Groups
	Tasks
	Task Type
	Task View
	Calendar View
	List View
	Task Due Date
	Task Tracking
-Time Log
-Reports & Analytics
-Email Notifications
-Import & Export
-Project Collaboration
-Default Status Workflow
-Default User Role Management


We use Orangescrum in our daily jobs to manage our customers information, projects. It is deployed in the production environment of our premium users, and we supported several organizations to deploy this community version on their servers as well. We take care of our open source edition similar than we do for our cloud/enterprise self-hosted edition, in fact both of them use the same code base structure. So feel free to use it in your organization or business!

## System Requirements



* Apache with `mod_rewrite`
	* Enable curl in php.ini
	* Change the 'post_max_size' and `upload_max_filesize` to 200Mb in php.ini
* PHP 5.6 or PHP 7.0, 7.1, 7.2
* cakephp 2.8
* MySQL 5.6 or 5.7
	* If STRICT mode is On, turn it Off.
	
## Installation

* Extract the archive. Upload the extracted folder(orangescrum-master) to your working directory.
* Provide proper write permission to "app/Config", "app/tmp" and "app/webroot" folders and their sub-folders.
Ex. chmod -R 0777 app/Config, chmod -R 0777 app/tmp, chmod -R 0777 app/webroot
You can change the write permission of "app/Config" folder after installation procedure is completed.
* Create a new MySQL database named "orangescrum"(`utf8_unicode_ci` collation).
* Get the database.sql file from the root directory and import that to your database.
* Locate your `app` directory, do the changes on following files:
  * `app/Config/database.php` - We have already updated the database name as "Orangescrum" which you can change at any point. In order to change it, just create a database using any name and update that name as database in DATABASE_CONFIG section. And also you can set a password for your Mysql login which you will have to update in the same page as password. [Required]
  * `app/Config/constants.php` - Provide your valid SMTP_UNAME and SMTP_PWORD. For SMTP email sending you can use(Only one at a time) either Gmail or Sendgrid or Mandrill. By default we are assuming that you are using Gmail, so Gmail SMTP configuration section is uncommented. If you are using Sendgrid or Mandrill just comment out the Gmail section and uncomment the Sendgrid or Mandrill configuration section as per your requirement. [Required]
  * `app/Config/constants.php` - Update the FROM_EMAIL_NOTIFY and SUPPORT_EMAIL [Required]
* Run the application as http://your-site.com/ from your browser and start using Orangescrum

For more information please visit below link:
    http://www.orangescrum.com/general-installation-guide

## Updates
New features, enhancements, and updates appear on a regular basis. You just need to follow these checkpoints:

Make sure to take a backup of your database and files
Replace all files in your directory with the updated version
If there were any database changes, the system will redirect your to <yourdomain.com>/update

Users can check the new releases at: www.orangescrum.com/open-source/release-notes

## Community
Need help to set up Orangescrum? Want to know more about cool enhancements? Feel free to visit our community support. You can also subscribe to our newsletter to get any important announcements and releases. www.orangescrum.com/blog/

## Report bugs
Did you find a bug? Please report it to our Orangescrum community forum. 

## Support / Contact


Get in touch with us here. We are available for any type of support, queries or help at all times. Feel free to join our discussion forums as well! 

-   Orangescrum Helpdesk  [http://helpdesk.orangescrum.com/](https://helpdesk.orangescrum.com/)
-   Contact Us  [https://www.orangescrum.com/contact/](https://www.orangescrum.com/contact-support/)
-   Community Forum [[https://www.orangescrum.com/contact/](https://www.orangescrum.com/contact-support/)/]([https://www.orangescrum.com/contact/](https://www.orangescrum.com/contact-support/)


## About 
Orangescrum open-source project management software is ideal for small teams or for individual usage.