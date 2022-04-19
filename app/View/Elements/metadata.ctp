<?php
$metatitle = "Project Management and Task Management Software | Orangescrum";
$metadesc = "Orangescrum is awesome Project Management and Task Management software; organize projects, team, documents and tasks at one place. No matter where your team or customers are, keeps everyone on the same page.";
$metakeyword = "Time management software, task management software, project management tools, time tracking software, project management software, resource management software, resource planning software, cloud project management, cloud based project management software, resource planning tool, project collaboration tools, small business project management software, project management software for small business, enterprise project management tools, resource availability, tracking software, enterprise project management, resource management tools, enterprise collaboration software, project planning tools, agile project management software, project management software, project management web app, timesheet management software, best collaboration software, agile project management, best online project management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software, best project management software, free project management software.";

$metakeyword_all = "Time management software, task management software, project management tools, time tracking software, project management software, resource management software, resource planning software, cloud project management, cloud based project management software, resource planning tool, project collaboration tools, small business project management software, project management software for small business, enterprise project management tools, resource availability, tracking software, enterprise project management, resource management tools, enterprise collaboration software, project planning tools, agile project management software, project management software, project management web app, timesheet management software, best collaboration software, agile project management, best online project management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software, best project management software, free project management software.";

if(PAGE_NAME == "signup"){
	$metatitle = "Quick Sign UP | Project Collaboration Tool | Orangescrum";
	$metadesc ="Quick Sign up to Orangescrum project collaboration tool in 60 seconds and avail 30 days free trails.";
	$metakeyword = "Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	if(trim($this->params->pass[0]) == 'getstarted'){
		$metatitle = "Get Started Orangescrum Project Collaboration Tool in 60 Seconds";
		$metadesc = "You can use Orangescrum project collaboration tool in 60 seconds and this is the right choice for smart people to get things done effortlessly.";
		$metakeyword ="Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	}else if(trim($this->params->pass[0]) == 'free'){
		$metatitle = "Free Sign UP #1 Project Management Software | Orangescrum";
		$metadesc = "Sign up Orangescrum project collaboration tool in 60 seconds and avail 30 days free trails";
		$metakeyword ="Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	}else{
		$metatitle = "Free Sign UP #1 Project Management Software | Orangescrum";
		$metadesc = "Sign up Orangescrum project collaboration tool in 60 seconds and avail 30 days free trails";
		$metakeyword ="Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	}
}elseif(PAGE_NAME == "excel_invo_templates"){
	$metatitle = "Free Invoice Template | Free Excel Invoice Template Orangescrum";
	$metakeyword = "Free Invoice Template, Free Excel Invoice Template Orangescrum, Free Excel Invoice Template, Invoice Template, Orangescrum Invoice Template";
	$metadesc = "Doesn't matter if you are a freelance or a small business, impress your clients with Orangescrum professional excel invoice template. You need to add your logo and share through email.";
}elseif(PAGE_NAME == "excel_projt_templates"){
	$metatitle = "Project Tracking Template | Free Excel Project Tracking Template Orangescrum";
	$metakeyword = "Project Tracking Template, Free Excel Project Tracking Template, Excel Project Tracking Template, Orangescrum.";
	$metadesc = "Free download Orangescrum excel project tracking template to manage and track your projects easily. Try the simplicity of Orangescrum.";
}elseif(PAGE_NAME == "all_free_templates"){
	$metatitle = "Free Excel Templates | Download Orangescrum Project Management Excel Templates";
	$metakeyword = "Free Excel Templates, Download Orangescrum Excel Templates, Project Management Excel Templates, Orangescrum Project Management Excel Templates, Free time sheet templates, free project tracking templates, Gantt Chart Free Excel Template, invoice templates.";
	$metadesc = "Download Orangescrum perfect free excel templates for you and your business and start managing your workplace and stay organized.";
}elseif(PAGE_NAME == "excel_gc_templates"){
	$metatitle = "Gantt Chart Template | Gantt Chart Free Excel Template";
	$metakeyword = "Gantt chart Template, Gantt Chart Free Excel Template, Free Excel Gantt Chart Template, Project management tool, task management software, time tracking software.";
	$metadesc = "Download Orangescrum Gantt chart excel template to manage scheduling of task with fun. Create, and share your task schedules with this modern and simplified Gantt chart template.";
}elseif(PAGE_NAME == "contact_support"){
	$metatitle = "Project Management and Task Management Software | Contact Support";
	$metakeyword = "Time management software, task management software, project management tools, time tracking software, project management software, resource management software, project management software for small business, enterprise project management tools, resource availability, enterprise project management, resource management tools, enterprise collaboration software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software, Orangescrum, Orangescrum Contact Support, Project Management Tool Contact Support.";
	$metadesc = "We understood your project management problems and egger to listen from you. We are 24x7 available for online support to help you better. Fill the form and share your quarry for instant support.";
}elseif(PAGE_NAME == "community_installation_support"){
	$metatitle = "Project Management Tool | Orangescrum | Community Installation Support";
	$metakeyword = "Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	$metadesc = "Orangescrum community installation support is the place to get paid support on Orangescrum open source edition installation query. Try it now to get productive in your business.";
}elseif(PAGE_NAME == "customer_support"){
	$metatitle = "Project Management and Task Management Software | Customer Support";
	$metakeyword = "Time management software, task management software, project management tools, time tracking software, project management software, resource management software, project management software for small business, enterprise project management tools, resource availability, enterprise project management, resource management tools, enterprise collaboration software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software, Orangescrum, Orangescrum customer";
	$metadesc = "We understood the project management problems of our valuable customer. We are 24x7 available for online support to help you better. Fill the form with your quarry for instant help and support.";
} elseif(PAGE_NAME == "pricing"){
	$metatitle = "Orangescrum Cloud and Self Hosted Plan and Pricing for Team";
	$metakeyword = "Orangescrum, Orangescrum Cloud, Orangescrum Self Hosted, Orangescrum Cloud Plan and Pricing, Orangescrum Self Hosted Plan and Pricing, Project collaboration tool, Project management software, Task Management, Task management software.";
	$metadesc = "Save your time and increase productivity with Orangescrum project collaboration software, affordable plan and pricing. All plans are FREE for 30 days, Sign up now.";
}elseif(PAGE_NAME == "timelog"){
	$metatitle = "Time Tracking Software | Time Tracking Tool | Online Time Tracking Software";
	$metakeyword = $metakeyword_all;
	$metadesc = "Orangescrum time log tool tracks down time spent by users and enable users to log their time spent with other relevant details on projects they work and generate invoices with ease";

}elseif(PAGE_NAME == "time_tracking"){
	$metatitle = "Time Tracking Software | Time Tracking Tool | Online Time Tracking Software";
	$metakeyword = 'Time Tracking, time tracking software, free time tracking software, time tracking tool, project time tracking software, online time tracking software, time tracking and invoicing software, time tracking and billing software, cloud based time tracking software, SaaS time tracking software, best time tracking app, online time tracker, simple time tracker, time track services, best hour tracking app, time tracking SaaS, time tracker.';
	$metadesc = "Orangescrum time tracking tool tracks down time spent by users and enable users to log their time spent with other relevant details on projects they work and generate invoices.";
}elseif(PAGE_NAME == "invoice_how_it_works"){
	$metatitle = "Project Management Software | Invoice Feature | Orangescrum";
	$metakeyword = "Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	$metadesc = "With Orangescrum project collaboration software invoice feature, billing and invoicing gets easier than ever. Create and add invoice items to your projects, save it to your system, print it or send it to your clients.";
}elseif(PAGE_NAME == "securities"){
	$metatitle = "Project Collaboration Software Data Security| Orangescrum";
	$metakeyword = "Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	$metadesc = "Project collaboration tool users and customer’s data security is our top most priority. We conduct routine security audits by top experts; use physical, procedural, and technical security of your information.";
}elseif(PAGE_NAME == "success_story"){
	$metatitle ="Project Management and Task Management Software | Success Story";
	$metakeyword = "Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	$metadesc ="Your success is our business. Orangescrum project management and task management software has achieved many successes through quality service. Have a look at our success stories.";
	if(trim($this->params->pass[0]) == 'sfcg'){
		$metatitle = "Marketing Agency Trusted Partner | Orangescrum";
		$metadesc = "12. With high quality service and support Orangescrum project collaboration tool has some valuable customer. Start organizing your team tasks with Orangescrum 30-day free trial";
		$metakeyword ="Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	}else if(trim($this->params->pass[0]) == 'brent'){
		$metatitle = "Project Management Software Success Story | Brent ";
		$metadesc = "Work management made effortless through collaborating with team, delegate tasks, control log file and generate invoice. Start organizing with Orangescrum app with 30 days free trail.";
		$metakeyword ="Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	}else if(trim($this->params->pass[0]) == 'saral'){
		$metatitle = "Project Management and Collaboration Software | Saral Success Story";
		$metadesc = "Orangescrum project management software made our tasks and timesheets so much easier and support provided by team is awesome. Try Orangescrum with 30 days free trail.";
		$metakeyword ="Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	}else if(trim($this->params->pass[0]) == 'cutmec'){
		$metatitle = "Project Management Software | Success Story of Cutmec | Orangescrum";
		$metadesc = "We are happy to share the success story of Cutmec, how his business has grown up with Orangescrum project management tool. Sign up now to Orangescrum simple project management tool and share your thoughts.";
		$metakeyword ="Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	}else if(trim($this->params->pass[0]) == 'bala'){
		$metatitle = "Project Management Software | Success Story of Bala";
		$metadesc = "Bala has achieved great success with Orangescrum project management and task management software. We are happy to share the success story of Bala because your business success is our business. Share your Orangescrum success story with us.";
		$metakeyword ="Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	}else if(trim($this->params->pass[0]) == 'sadanand'){
		$metatitle = "Project Management Software | Success Story of Sadanand | Orangescrum";
		$metadesc = "We are happy to share the success story of Sadanand, how his business has grown up with Orangescrum project management tool. Try Orangescrum now and share your thoughts.";
		$metakeyword ="Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	}else if(trim($this->params->pass[0]) == 'khulu'){
		$metatitle = "Project Management Software | Success Story of Khulu";
		$metadesc = "Orangescrum project management and task management software has provided great success to Khulu. We are happy to share the success story of Khulu because your business success is our business. Share your Orangescrum success story with us.";
		$metakeyword ="Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	}else if(trim($this->params->pass[0]) == 'pedro'){
		$metatitle = "Project Management and Task Management Software | Pedro Success Story";
		$metadesc = "Pedro has got huge success in his business with Orangescrum project management and task management tool. Customer success is Orangescrum business success. Have a look at the success story of Pedro.";
		$metakeyword ="Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	}else{
		$metatitle = "Project Management and Collaboration Software | Orangescrum | Success Story";
		$metadesc = "Your success is our business. Orangescrum project management and collaboration software has achieved many successes through quality service. Have a look at our success stories";
	}
}elseif(PAGE_NAME == "tutorial"){
	$metatitle ="Project management and Project Collaboration Tutorial | Orangescrum";
	$metadesc ="Project management is the most important and challenging task for each project manager. Project management tutorials has great role in gathering knowledge on project management features and methodology to maximize the productivity of business. We have built various types of project management tutorials for your knowledge.";
	$metakeyword = "Project Management, Project Management tutorial, schedule management, schedule management tutorial, Performance Management, Performance Management tutorial, Quality Management, Communications Management, Supplier Management, Resources Management, Resources Management tutorial, Project Management terminologies, Operational management tutorial, Operational management, project collaboration, managing resources, Project Scheduling, project management models, Project Management Methodologies, Project Management Method, Project Management Agile Method, Agile methodology, Scrum Methodology, Scrum Methodology tutorial, Waterfall methodology.";	
	if(isset($this->params->pass[1]) && trim($this->params->pass[1]) == 'introduction-to-project-management-terminologies'){
		$metatitle = "Introduction to Project Management Terminologies | Orangescrum Tutorial";
		$metadesc = "Project management is the most important and demanding matrix to maximize the productivity. With the rapid proliferation of technology, the importance of project management has increased exponentially. So idea on project management terminology is much required for a project manager.";
		$metakeyword ="Project management, Project Management terminologies, Project manager, enterprise Project management, Operational management, Operations Management.";
	}else if(isset($this->params->pass[1]) && trim($this->params->pass[1]) == 'how-to-kick-start-your-projects-with-project-management-tool'){
		$metatitle = "How to Kick Start your Projects with Project Management Tool | Orangescrum tutorial";
		$metadesc = "Project kick-off meeting is the most essential part of project success. A project manager’s responsibility is to keep track of all efforts and these must be deputed to ensure the things on the right note with our best foot forward.";
		$metakeyword ="Project, How to Kick Start your Project, Project Kick-Off Meeting, Project Team, Project Manager, RACI Matrix, Project Execution, Gantt Chart, Kanban View, Workflow Management, productivity, Resource Availability, Resource Utilization, Daily Catch-Up, Risk Mitigation Plan.";
	}else if(isset($this->params->pass[1]) && trim($this->params->pass[1]) == 'project-management-methodologies'){
		$metatitle = "Project Management Methodologies | Orangescrum tutorial";
		$metadesc = "There are various types of Project management methodology which can help a project manager to organize business, streamline the process and makes team collaboration more efficient to get more productivity. We have covered all the above with this tutorial with an objective to help you in project management.";
		$metakeyword ="Project Management, Project Management Methodologies, Agile Methodology, Agile Methodology process, Benefit of Agile methodology, Disadvantages of Agile methodology, Scrum Methodology, Scrum Methodology process, Benefit of Scrum methodology, Disadvantages of scrum methodology, Waterfall methodology, Waterfall methodology process, Advantages of waterfall methodology, Disadvantages of waterfall methodology.";
	}else if(isset($this->params->pass[1]) && trim($this->params->pass[1]) == 'pmo-and-its-role-in-organization'){
		$metatitle = "PMO And Its Role in Organization | Orangescrum Tutorial";
		$metadesc = "PMO is the source of documentation, guidance and metrics on the practice of project management and execution. PMO helps in decision making, performance management, schedule management, quality management, communication management and supplier management.";
		$metakeyword ="PMO, Role of PMO, project management office, project management, Functions of PMO, Performance Management, Schedule Management, Quality Management, Communications Management, Supplier Management.";
	}else if(trim($this->params->pass[0]) == 'introduction-to-project-management'){
		$metatitle = "Introduction To Project Management | Orangescrum Tutorial";
		$metadesc = "Project Management is one of the top and risky job for any Project Manager. Here in this tutorial we have share the basic things of project management, features and methodology which one can learn and implement in real life.";
		$metakeyword ="Project Management tutorial, schedule management tutorial, Performance Management tutorial, Quality Management tutorial, Communications Management tutorial, project collaboration tutorial,  project management models tutorial.";
	}
}elseif(PAGE_NAME == "enterprise_home"){
	$metatitle = "Self-Hosted | Self-Hosted Project Management Software | Orangescrum";
	$metakeyword = "Self-hosted, Orangescrum self-hosted, Self-hosted services, Project management software Self-hosted, Project collaboration tool Self-hosted, task management software Self-hosted.";
	$metadesc = "Orangescrum self-hosted service built for teams, group and companies to accelerate business with commanding project collaboration capabilities in your own premises. Try now.";
}elseif(PAGE_NAME == "give_away"){
	$metatitle = "Simple Project Management Tool | Orangescrum | Giveaway";
	$metakeyword = "Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	$metadesc = "Orangescrum simple project collaboration tool offering various types of giveaway and subscription offers to make your project management easy. Makes work fun with easy to follow and interactive UI, enabling team collaboration, real-time insights, and update sharing.";
}elseif(PAGE_NAME == "forgotpassword"){
	$metatitle = "Project Management and Task Management Software Forget Password";
	$metakeyword = "Time management software, task management software, project management tools, time tracking software, project management software, resource management software, resource planning software, cloud project management, cloud based project management software, resource planning tool, project collaboration tools, small business project management software, project management software for small business, enterprise project management tools, resource availability, tracking software, enterprise project management, resource management tools, enterprise collaboration software, project planning tools, agile project management software, project management software, project management web app, timesheet management software, best collaboration software, agile project management, best online project management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software, best project management software, free project management software.";
	$metadesc = "You can reset your password with your email address to sign in to your Orangescrum project management and task management software easily.";
}elseif(PAGE_NAME == "mobile_app"){
	$metatitle = "THE ORANGESCRUM | Project Collaboration and Task Management Mobile App";
	$metakeyword = "The Orangescrum, THE Orangescrum mobile app, Orangescrum mobile app, Orangescrum android mobile app, Orangescrum iPhone mobile app, Project collaboration tool, Project collaboration tool mobile app, Task management software, Task management software mobile app, Task management mobile app, Project collaboration tool, Project collaboration tool mobile app, Project collaboration mobile app.";
	$metadesc = "THE Orangescrum Mobile App for your teams who want to stay ahead in project management and task management. You can connect and manage your team and projects at any moment. Download Now";
}elseif(PAGE_NAME == "site_map"){
	$metatitle = "Project Collaboration and Task Management Software Web Site Map";
	$metakeyword = "Time management software, task management software, project management tools, time tracking software, project management software, resource management software, resource planning software, cloud project management, cloud based project management software, resource planning tool, project collaboration tools, small business project management software, project management software for small business, enterprise project management tools, resource availability, tracking software, enterprise project management, resource management tools, enterprise collaboration software, project planning tools, agile project management software, project management software, project management web app, timesheet management software, best collaboration software, agile project management, best online project management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software, best project management software, free project management software.";
	$metadesc = "Here you will find the list of old and new pages of Orangescrum project collaboration and task management software for users guide.";
}elseif(PAGE_NAME == "gantt_chart"){
	$metatitle = "Gantt Chart | Simplified & Visual Project Planning | Orangescrum";
	$metakeyword = $metakeyword_all;
	$metadesc = "With Orangescrum project management tool grant chart add-on one can do simplified and intuitive visual project planning to prevents unwanted delays and keeps the teams in sync";
}
elseif(PAGE_NAME == "kanban_view"){
	$metatitle = "Project Collaboration Tool | Kanban View";
	$metakeyword = "Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	$metadesc = "Orangescrum’s Kanban View gives a clear picture of the entire project on what has been done, what needs to be done and what is in progress. Try Orangescrum with 30 days free trail.";
}elseif(PAGE_NAME == "aboutus"){
	$metatitle = "Project Collaboration Tool | Project Management Software | Orangescrum";
	$metakeyword = "Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	$metadesc = "Orangescrum project collaboration tool gives an eagle's-eye view on the productivity and progress of your projects and team. Task management, time tracking, control log file and generate invoice can easily done with this.";
}elseif(PAGE_NAME == "tour"){
	$metatitle = "Project Management and Collaboration Software Tour | Orangescrum";
	$metakeyword = "Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	$metadesc = "Quick and clear tour of project management and collaboration software to get things done efficiently with Orangescrum. Try Orangescrum with 30 days free trail.";
}elseif(PAGE_NAME == "compareos"){
	$metatitle = "Comparison of Different Versions of Orangescrum Project Collaboration Tool";
	$metakeyword = "Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	$metadesc = "Here you can check the comparison of different versions (open source, cloud and on-Premises) of Orangescrum project collaboration tool";
}elseif(PAGE_NAME == "timesheet_templates"){
	$metatitle = "Timesheet Template | Free Timesheet Template | Free Download Timesheet Template";
	$metakeyword = "Timesheet Template, Free Timesheet Template, Free Download Timesheet Template, timesheet in excel, timesheet format,timesheet format in excel,timesheet format in word, timesheet format in pdf, free download timesheet format in excel, free download timesheet format in word, free download timesheet format in pdf, track your team timesheet.";
	$metadesc = "Free download timesheet template from Orangescrum in word, excel and pdf format to track your team daily, weekly and monthly time to know your productivity easily. Download free now ";
}elseif(PAGE_NAME == "affiliates"){
	$metatitle = "Orangescrum Affiliate Program | Start Earning Effortlessly";
	$metakeyword = $metakeyword_all;
	$metadesc = "Earn money by referring Orangescrum project collaboration tool to your clients or website visitors. Customers whom you refer will get an elegant way to manage projects, team and tasks at one place";
}elseif(PAGE_NAME == "slack_integration"){
	$metatitle = "Slack Integration with Orangescrum Project Collaboration Tool";
	$metakeyword = "Slack Integration, Orangescrum, Project Collaboration Tool, Orangescrum Project Collaboration Tool, Slack Integration with Orangescrum, Slack Integration process, Slack Integration steps";
	$metadesc = "Slack integration helps real-time messaging, archiving and search for modern teams in your Orangescrum Project Collaboration Tool.";
}elseif(PAGE_NAME == "privacypolicy"){
	$metatitle = "Project Collaboration Tool | Privacy Policy | Orangescrum ";
	$metakeyword = "Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
	$metadesc = "We keep privacy of your information and maintaining privacy of your information is of paramount importance to us as it helps foster confidence, goodwill and stronger relationships with you, our customers.";
}elseif(PAGE_NAME == "termsofservice"){
	$metatitle = "Project Management and Collaboration Software | Terms of Services";	
	$metadesc = "You must have to read and agree with project management and collaboration software terms of services before registration and written negotiated agreement signed by Andolasoft and you.";
	$metakeyword ="Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
}elseif(PAGE_NAME == "task_groups"){
	$metatitle = "Project Collaboration Tool | Task Groups | Orangescrum";
	$metadesc = "Orangescrum helps to accomplish a specific task in a project in collaboration with proper information sharing in proper control without any conflict and for better productivity.";
	$metakeyword ="Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
}elseif(PAGE_NAME == "project_management"){
	$metatitle = "Project Management | Project Collaboration Software | Orangescrum";
	$metadesc = "Orangescrum project management tool helps in collaborating people with different roles and responsibilities with objectives towards successful project completion on Time, within Budget.";
	$metakeyword = "Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software."; 
}elseif(PAGE_NAME == "task_management"){
	$metatitle = "Task Management Tool | Task Management Software | Orangescrum";
	$metadesc = "Orangescrum is one of the simplified task management software with all latest features to assign, manage and evaluate progress of all your tasks. Efficient task management helps in proper resource utilization to get productivity and track the project progress.";
	$metakeyword = "Task Management, Task Management App, Task Management Software, Task Management System, Task Management Tool, Cloud Task Management, Cloud Task Management Software."; 
}elseif(PAGE_NAME == "choose_orangescrum"){
	$metatitle = "Why Project Management | Orangescrum Project Management Tool";
	$metadesc = "Orangescrum is the simplified project management software designed for what matters the most to you. Orangescrum offers a single platform that boosts team collaboration and enables faster execution and timely delivery";
	$metakeyword = "Why Orangescrum, Simplified Project Management, Simplified Project Management tool, Simplified Project Management software, Project Management tool, Project Management software, enterprise project management, self-hosted project management tool"; 
}elseif(PAGE_NAME == "resource_utlization"){
	$metatitle = "Resource Availability | Resource Utilization | Orangescrum Resource Management Tool";
	$metadesc = "Utilize your resources in a very simplified way with Orangescrum resource management tool for project success. Proper utilization of resources is the key for business success. Sign up Orangescrum.";
	$metakeyword = "Resource Availability, Resource Management, Resource Utilization, Resource Availability in Business, Utilization or Resource, Efficient resources utilization, Project Management Tool, Project Management software, Project collaboration Tool, Project collaboration software, Task Management Tool, Task Management software."; 
}elseif(PAGE_NAME == "catch_up"){
	$metatitle = "Project Collaboration Software Daily Catch Up | Orangescrum";
	$metadesc = "Orangescrum project collaboration tool daily catch-up helps you to track your team and their tasks without any physical follow-up and you can also know the team is doing these in smarter way.";
	$metakeyword ="Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
}elseif(PAGE_NAME == "updates"){
	$metatitle = "Project Collaboration Tool | Latest Updates & Fixes | Orangescrum";
	$metadesc = "The latest updates are come straight from Orangescrum Research and Development warehouse. You can also subscribe to get the latest Orangescrum updates right in your inbox.";
	$metakeyword="Time management software, time log tool, task management software, online project management tools, time tracking software, online project management software, resource management software, resource planning software, cloud project management, tracking software, enterprise project management, resource management tools, enterprise collaboration software, timesheet management software, SaaS project management software, enterprise project collaboration software, Project Management and Collaboration Software, Project Collaboration Software, Project Collaboration Tool, Project Management tool, project management software.";
}elseif(PAGE_NAME == "community"){
	$metatitle = "Community - Orangescrum";
	$metadesc = "Learn, Share & Contribute by joining the Orangescrum Community. Flexible project management web application written using CakePHP framework";
}
elseif(PAGE_NAME == "enterprise_home"){
	$metatitle = "Orangescrum Self-Hosted | Self-Hosted Project Collaboration Tool";
	$metadesc = "Orangescrum self-hosted project management software provides powerful project collaboration, invoicing and time tracking with the advantage of Increased Data Security.";
	$metakeyword = "Orangescrum, Orangescrum Cloud, Orangescrum Self Hosted, Orangescrum Cloud Plan and Pricing, Orangescrum Self Hosted Plan and Pricing, Project collaboration tool, Project management software, Task Management, Task management software, self-hosted Project collaboration tool, self-hosted project management software, self-hosted Task management software."; 
}
elseif(PAGE_NAME == "about_timesheet"){
	$metatitle = "Timesheet | Time Management | Time Tracking Tool | Resource Management";
	$metadesc = "Manage your workforce with online timesheet software. Orangescrum timesheets is for tracking projects and teams hourly working details to manage your resources. Try Time sheet now";
	$metakeyword = "Time Management, Time Tracking, Automated Time Tracking, Time Tracking Tool, Time Tracking Software, Task Management, Resource Management, online timesheets, time tracking timecard, time tracking, weekly time sheet, monthly time sheet, daily time sheet."; 
}
elseif(PAGE_NAME == "marketing_industry"){
	$metatitle = "Project Management Tool for Marketing Solutions | Orangescrum";
	$metakeyword = "Orangescrum project management solutions, project management for marketing team, project management tools, time tracking software, task management software, case, management software, project planning software, resource management software, bug tracking system, workload management, schedule management, stakeholder management tools, budget management tools, project collaboration tools.";
	$metadesc = "Orangescrum project management tool to organize your clients and project with the ability to quickly replicate processes as you grow and effortlessly collaborate with teams, delegate tasks, and control time logs.";
}
elseif(PAGE_NAME == "it_industry"){
	$metatitle = "Project Management Tool for IT Solutions | Orangescrum";
	$metadesc = "Orangescrum the all-in-one project portfolio management platform to manage your time, resource, cost, project planning and delivery effortlessly.";
	$metakeyword = "Orangescrum project management solutions, project management for IT solutions, project management tools, time tracking software, task management software, case, management software, project planning software, resource management software, bug tracking system, workload management, schedule management, stakeholder management tools, budget management tools, project collaboration tools.";
}elseif(PAGE_NAME == "refer_a_friend"){
	$metatitle = "Refer Your Friends and Earn Money with Orangescrum Project Management Tool";
	$metadesc = "Now you will get reward for sending people our way! Through Orangescrum project management tool referral program you can earn $30 for each referral with your friend and colleagues.";
	$metakeyword = "Refer Your Friends, Refer Your Friends to Orangescrum, Orangescrum referral program, project management tool referral program.";
}elseif(PAGE_NAME == "all_features"){
	$metatitle = "Project Management Tool All Features At One Place To Stay Productive | Orangescrum";
	$metadesc = "No more switching between various tools to perform various tasks like task management, time tracking, resource management, Gantt chart, Kanban view and  in app chat. Orangescrum Project Collaboration Tool has all the features and we have kept these in a single page for your usability.";
	$metakeyword = "Orangescrum, Project management tool, Project collaboration tool, task management, time tracking, resource management, Gantt chart, Kanban view, in app chat, schedule management, resource utilization, Orangescrum mobile app, timesheet, resource availability.";
}

?>
<title><?php echo $metatitle; ?></title>
<meta name="description" content="<?php echo $metadesc; ?>" />
<meta name="keywords" content="<?php echo $metakeyword; ?>"/>
<?php if(PAGE_NAME == "home") { ?>
<meta property="og:url" content="<?php echo HTTP_ROOT;?>" />
<?php } ?>
<meta property="og:type" content="Website" />
<meta property="og:site_name" content="Orangescrum" />
<meta property="og:title" content="<?php echo $metatitle; ?>" />
<meta property="og:description" content="<?php echo $metadesc; ?>"/>

<?php if(PAGE_NAME == "free_download") { ?>
<meta property="og:image" content="<?php echo HTTP_ROOT."img/downlod.png"?>" />
<link rel="image_src" href="<?php echo HTTP_ROOT."img/downlod.png"?>" />
<?php } else { ?>
<?php /*
<meta property="og:image" content="<?php echo HTTP_ROOT."img/osbackground.png"?>" />
<link rel="image_src" href="<?php echo HTTP_ROOT."img/osbackground.png"?>" /> */ ?>
<?php } ?>