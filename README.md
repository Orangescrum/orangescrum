![Orangescrum Logo](https://www.orangescrum.com/blog/wp-content/uploads/2022/04/Orangescrum-Logo.png)


![GitHub all releases](https://img.shields.io/github/downloads/orangescrum/orangescrum/total)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/orangescrum/orangescrum)
![GitHub commit activity](https://img.shields.io/github/commit-activity/m/orangescrum/orangescrum)
![GitHub repo size](https://img.shields.io/github/repo-size/orangescrum/orangescrum)
![GitHub issues](https://img.shields.io/github/issues/orangescrum/orangescrum)
![GitHub closed issues](https://img.shields.io/github/issues-closed/orangescrum/orangescrum)


# [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#free-open-source-project-management-software)Free, open source Project Management software

## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#introduction)Introduction

Orangescrum is the simple yet powerful free and open source project management software that allows teams to organize their tasks, projects and resources with real time project collaboration. Track the task progress and get notifications on their completion with the Orangescrum project management tool. Get the complete picture of all tasks and team activities in real-time. Orangescrum also offers SaaS/Cloud edition and an option to upgrade the community edition to enterprise self-hosted edition.

Orangescrum open-source is a flexible project management web application written using CakePHP.

New features, enhancements, and updates are released on a regular basis.

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

## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#task-list-view)Task List View
![TaskList](https://user-images.githubusercontent.com/104009174/164024431-7a2aa224-f01a-4a89-a04f-edfdc7a64180.png)
## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#add-edit-task-form-view)Add/Edit Task Form View
![Task](https://user-images.githubusercontent.com/104009174/164024438-ba48ce20-eb87-4268-be2a-b6f3b9e64108.png)
## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#task-details-view)Task Details View
![TaskDetail](https://user-images.githubusercontent.com/104009174/164024414-8a4d6117-b200-409d-9cf4-0f3d1585a76d.png)
## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#project-list-view)Project Card View
![Project](https://user-images.githubusercontent.com/104009174/164024428-a42a6b4b-8c48-49f9-a65d-c463eb78d578.png)
## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#dashboard-view)Dashboard View
![DashBoard](https://user-images.githubusercontent.com/104009174/164024434-c8821926-b57f-4f53-9136-e4da33fc6304.png)

We use Orangescrum in our daily jobs to manage our customers information, projects. It is deployed in the production environment of our premium users, and we supported several organizations to deploy this community version on their servers as well. We take care of our open source edition similar than we do for our cloud/enterprise self-hosted edition, in fact both of them use the same code base structure. So feel free to use it in your organization or business!

## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#system-requirements)System Requirements

-   Apache with  `mod_rewrite`
    -   Enable curl in php.ini
    -   Change the 'post_max_size' and  `upload_max_filesize`  to 200Mb in php.ini
-   PHP 7.2
-   cakephp 2.8
-   MySQL 5.6 or 5.7
    -   If STRICT mode is On, turn it Off.

## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#how-to-download)How to Download the Package from Orangescrum GitHub repository?

To download the Orangescrum Open-source package from the GitHub repository, please follow the process:

-   Go to xampp/htdocs
![HTDOCS](https://www.orangescrum.com/blog/wp-content/uploads/2022/04/HTDOCS.png)
-   Open git bash here. (As shown in below image)
![GitBash](https://www.orangescrum.com/blog/wp-content/uploads/2022/04/GitBash.png)
-   Go to your GitHub account and search for Orangescrum. Or click here to find the Orangscrum Repository.
![Click-On-Codes.png](https://www.orangescrum.com/blog/wp-content/uploads/2022/04/Click-On-Codes.png)
-   Click on the code and copy the link.
-   Go to git bash terminal  and add Command line: git clone <github link>  (the link you have copied from GitHub)
![Copy-the-link](https://www.orangescrum.com/blog/wp-content/uploads/2022/04/Copy-the-link.png)
-   Click on enter. Orangescrum folder will be generated inside your htdocs.
-   Otherwise, download the zip file and extract the file inside your htdocs.
![Download-the-Zip](https://www.orangescrum.com/blog/wp-content/uploads/2022/04/Download-the-Zip.png)

## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#installation)Installation

-   Extract the archive. Upload the extracted folder(orangescrum-master) to your working directory.
-   Provide proper write permission to "app/Config", "app/tmp" and "app/webroot" folders and their sub-folders. Ex. chmod -R 0777 app/Config, chmod -R 0777 app/tmp, chmod -R 0777 app/webroot You can change the write permission of "app/Config" folder after installation procedure is completed.
-   Create a new MySQL database named "orangescrum"(`utf8_unicode_ci`  collation).
-   Get the database.sql file from the root directory and import that to your database.
-   Locate your  `app`  directory, do the changes on following files:
    -   `app/Config/database.php`  - We have already updated the database name as "Orangescrum" which you can change at any point. In order to change it, just create a database using any name and update that name as database in DATABASE_CONFIG section. And also you can set a password for your Mysql login which you will have to update in the same page as password. [Required]
-   Run the application as  [https://www.your-site.com/](http://your-site.com/)  from your browser and start using Orangescrum

For more information please visit below link:  [https://www.orangescrum.com/open-source/general-installation-guide](http://orangescrum.com/open-source/general-installation-guide)

## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#Languages)Supported Languages
	
Orangescrum community edition supports the following languages:
	
- Danish
- English
- French
- German
- Portuguese
- Spanish

## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#updates)Updates

New features, enhancements, and updates appear on a regular basis. You just need to follow these checkpoints:

Make sure to take a backup of your database and files Replace all files in your directory with the updated version.

Users can check the new releases at:  [https://www.orangescrum.com/open-source/release-notes](http://orangescrum.com/open-source/release-notes)

## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#community)Community

Need help to set up Orangescrum? Want to know more about cool enhancements? Feel free to visit our [community forum](https://groups.google.com/g/orangescrum-community-support). You can also subscribe to our [newsletter](https://orangescrum.com/blog/) to get any important announcements and releases. 

## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#report-bugs)Report bugs

Did you find a bug? please [create an issue](https://github.com/Orangescrum/orangescrum/issues) for it before starting any work on a pull request.

## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#support--contact)Support / Contact

Get in touch with us here. We are available for any type of support, queries or help at all times. Feel free to join our discussion forums as well!

-   Orangescrum Helpdesk  [https://www.helpdesk.orangescrum.com/](https://helpdesk.orangescrum.com/)
-   Contact Us  [https://www.orangescrum.com/contact/](https://orangescrum.com/contact-support/)
-   Community Forum [https://groups.google.com/g/orangescrum-community-support](https://groups.google.com/g/orangescrum-community-support)

## [](https://github.com/Orangescrum/orangescrum/blob/main/README.md#about)About

Orangescrum open-source project management software is ideal for small teams or for individual usage.