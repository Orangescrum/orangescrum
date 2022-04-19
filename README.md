
## Readme:

# [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#free-open-source-project-management-software)Free, open source Project Management software

## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#introduction)Introduction

Orangescrum is the simple yet powerful free and open source project management software that allows teams to organize their tasks, projects and resources with real time project collaboration. Track the task progress and get notifications on their completion with the Orangescrum project management tool. Get the complete picture of all tasks and team activities in real-time. Orangescrum also offers SaaS/Cloud edition and an option to upgrade the community edition to enterprise self-hosted edition.

Orangescrum open-source is a flexible project management web application written using CakePHP.

New features, enhancements, and updates released on a regular basis.

Pull requests and bug reports are always welcome!

Visit our [website](https://www.orangescrum.com/)  to get a free trial of the premium service.

## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#features)Features

Orangescrum provides the rich set features of Project Management.

The key features are:

- [Task Management](https://www.orangescrum.com/task-management)
	-  Task Groups 
	- Tasks 
	- Task Type 
	- Task View 
		- Calendar View 
		- List View 
	- Task Due Date 
	- Task Tracking 
- [Time Log](https://www.orangescrum.com/time-tracking)
- [Reports & Analytics](https://www.orangescrum.com/project-reports-analytics)
- Email Notifications 
- Import & Export 
- [Project Collaboration](https://www.orangescrum.com/agile-project-management)
- [Default Status Workflow](https://www.orangescrum.com/custom-status-workflow)
- [Default User Role Management](https://www.orangescrum.com/user-role-management)

We use Orangescrum in our daily jobs to manage our customers information, projects. It is deployed in the production environment of our premium users, and we supported several organizations to deploy this community version on their servers as well. We take care of our open source edition similar than we do for our cloud/enterprise self-hosted edition, in fact both of them use the same code base structure. So feel free to use it in your organization or business!

## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#system-requirements)System Requirements

-   Apache with  `mod_rewrite`
    -   Enable curl in php.ini
    -   Change the 'post_max_size' and  `upload_max_filesize`  to 200Mb in php.ini
-   PHP 7.2
-   cakephp 2.8
-   MySQL 5.6 or 5.7
    -   If STRICT mode is On, turn it Off.

## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#installation)Installation

-   Extract the archive. Upload the extracted folder(orangescrum-master) to your working directory.
-   Provide proper write permission to "app/Config", "app/tmp" and "app/webroot" folders and their sub-folders. Ex. chmod -R 0777 app/Config, chmod -R 0777 app/tmp, chmod -R 0777 app/webroot You can change the write permission of "app/Config" folder after installation procedure is completed.
-   Create a new MySQL database named "orangescrum"(`utf8_unicode_ci`  collation).
-   Get the database.sql file from the root directory and import that to your database.
-   Locate your  `app`  directory, do the changes on following files:
    -   `app/Config/database.php`  - We have already updated the database name as "Orangescrum" which you can change at any point. In order to change it, just create a database using any name and update that name as database in DATABASE_CONFIG section. And also you can set a password for your Mysql login which you will have to update in the same page as password. [Required]
    -   `app/Config/constants.php`  - Provide your valid SMTP_UNAME and SMTP_PWORD. For SMTP email sending you can use(Only one at a time) either Gmail or Sendgrid or Mandrill. By default we are assuming that you are using Gmail, so Gmail SMTP configuration section is uncommented. If you are using Sendgrid or Mandrill just comment out the Gmail section and uncomment the Sendgrid or Mandrill configuration section as per your requirement. [Required]
    -   `app/Config/constants.php`  - Update the FROM_EMAIL_NOTIFY and SUPPORT_EMAIL [Required]
-   Run the application as  [https://www.your-site.com/](http://your-site.com/)  from your browser and start using Orangescrum

For more information please visit below link:  [https://www.orangescrum.com/general-installation-guide](http://orangescrum.com/general-installation-guide)

## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#updates)Updates

New features, enhancements, and updates appear on a regular basis. You just need to follow these checkpoints:

Make sure to take a backup of your database and files Replace all files in your directory with the updated version If there were any database changes, the system will redirect your to <yourdomain.com>/update

Users can check the new releases at:  [https://www.orangescrum.com/open-source/release-notes](http://orangescrum.com/open-source/release-notes)

## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#community)Community

Need help to set up Orangescrum? Want to know more about cool enhancements? Feel free to visit our [community support](https://groups.google.com/g/orangescrum-community-support). You can also subscribe to our [newsletter](https://orangescrum.com/blog/) to get any important announcements and releases. 

## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#report-bugs)Report bugs

Did you find a bug? please [create an issue](https://github.com/Orangescrum/orangescrum/issues) for it before starting any work on a pull request.

## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#support--contact)Support / Contact

Get in touch with us here. We are available for any type of support, queries or help at all times. Feel free to join our discussion forums as well!

-   Orangescrum Helpdesk  [https://www.helpdesk.orangescrum.com/](https://helpdesk.orangescrum.com/)
-   Contact Us  [https://www.orangescrum.com/contact/](https://orangescrum.com/contact-support/)
-   Community Forum [https://groups.google.com/g/orangescrum-community-support](https://groups.google.com/g/orangescrum-community-support)

## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#about)About

Orangescrum open-source project management software is ideal for small teams or for individual usage.

