var tour = {
  id: 'hello-hopscotch',
  steps: [
    {
      target: 'new_onboarding_add_icon',
      title: _('Create Task'),
      content: _('Add Tasks to your project just created, then assign & start collaborating...'),
      placement: 'bottom',
	    yOffset: -18,
      arrowOffset: 7
    },
	{
      target: 'no-task-crt-task',
      title: _('Create New Task'),
      content: _('Add Tasks to your projects, assign and collaborate...'),
      placement: 'bottom',
      arrowOffset: 30
    },
	{
      target: 'new_task_label',
      placement: 'bottom',
      title: _('Quick Task'),
      content: _('Create task quickly - enter Due Date, Task Type, Assign To & Estimated Hour'),
      yOffset: -4,
	  arrowOffset: 20
    },
    {
      target: 'no-task-impt-task',
      placement: 'bottom',
      title: _('Migrating from somewhere else?'),
      content: _('Click here to import all your tasks into Orangescrum...'),
      yOffset: -7
    },
    {
      target: 'left_menu_nav_tour',
      title: _('Easy Navigation'),
      content: _('Navigate swiftly between My Task, Overdue & others'),
      placement: 'right',
      //xOffset: -15,
	  //yOffset: -10
	  arrowOffset: 10
    },
    {
      target: 'task_filter',
      placement: 'left',
      title: _('Apply Filter'),
      content: _('Filter by narrowing down your search. Save your filter for quick reference'),
      yOffset: -15,
	  xOffset: 10,
	  arrowOffset: 1
    },
    {
      target: 'ajaxCaseStatus',
      placement: 'bottom',
      title: _('Quick Filter: Task Status'),
      content: _('Difference out Tasks based on their status'),
      //yOffset: -17
	  arrowOffset: 24
    },
    {
      target: 'topactions',
      placement: 'bottom',
      title: _('Access to different Task view?'),
      content: _('Access preferred Task view - Task List/Task Group/Kanban or Calendar view'),
      xOffset: 54,
	  yOffset: 5,
      arrowOffset: 75,
    },
    {
      target: 'task_impExp',
      placement: 'left',
      title: _('Export tasks'),
      content: _('Export tasks in CSV/PDF'),
	  yOffset: -15,
	  xOffset: 5,
	  arrowOffset: 1
    },    
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};


var tour_crttask = {
  id: 'hello-hopscotch',
  steps: [
    {
      target: 'CS_title',
      title: _('Task Title'),
      content: _('Name the task to create'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },
	/*{
      target: 'CS_parent_task',
      title: _('Parent Task'),
      content: _('Select a parent task to create subtask.'),
      placement: 'bottom',
	  yOffset: 25,
      arrowOffset: 70
    },*/	
	{
      target: 'tour_crt_asign',
      title: _('Assign To'),
      content: _("Select the user to work on it"),
      placement: 'bottom',
			yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_type',
      title: _('Task Type'),
      content: _('Classify tasks for better understanding or select from predefined task types (e.g. Development, Bug)'),
      placement: 'bottom',
			yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_prio',
      title: _('Set Priority'),
      content: _('Define the right priority here'),
      placement: 'bottom',
			yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_desc',
      title: _('Task Description'),
      content: _('A quick description of the task. For repetitive tasks, simply select the template'),
      placement: 'bottom',
			yOffset: -9,
      arrowOffset: 70,
			delay: 100
    },{
      target: 'tour_crt_attach',
      title: _('Attach Files'),
      content: _('Drag and Drop your files. Files from Dropbox/Google drive can be attached too'),
      placement: 'bottom',
			yOffset: -9,
      arrowOffset: 70,
			onNext: function() {
				setTimeout(function() {
					$('.flex_scroll').scrollTop(100);
				},100);
			},
			onPrev: function() {
				setTimeout(function() {
					$('.flex_scroll').scrollTop(0);
				},100);
			}
    },{
      target: 'tour_crt_srtend',
      title: _('Start & End Date'),
      content: _('Time-box your task to keep track of it'),
      placement: 'bottom',
			yOffset: -9,
			delay: 100,
      arrowOffset: 70
    },{
      target: 'tour_crt_tskgrp',
      title: _('Task Group'),
      content: _('Use it to group related tasks.'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70,
			delay: 100
    },{
      target: 'tour_crt_estmtd',
      title: _('Estimated Hours'),
      content: _('Set the planned time for completion of the task'),
      placement: 'bottom',
			yOffset: -9,
      arrowOffset: 70,
			onNext: function() {
				setTimeout(function() {
					$('.flex_scroll').scrollTop(200);
				},100);
			},
			onPrev: function() {
				setTimeout(function() {
					$('.flex_scroll').scrollTop(100);
				},100);
			}
    },
		{
      target: 'tour_crt_timrng',
      title: _('Time Range'),
      content: _('Define a specific time range for the task including breaks; Spent hours will be auto-calculated'),
      placement: 'bottom',
			yOffset: -9,
			arrowOffset: 70,
			delay: 100,
		},
		{
      target: 'tour_crt_recur',
      title: _('Recurring'),
      content: _('Repeat tasks per frequency - Daily, Weekly, Monthly or Yearly'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70,
			delay: 100
    },{
      target: 'tour_crt_isbil',
      title: _('Is Billable?'),
      content: _('Select to track billable hours'),
      placement: 'bottom',
			yOffset: -9,
      arrowOffset: 70,
			onNext: function() {
				setTimeout(function() {
					$('.flex_scroll').scrollTop(250);
				},100);
			},
			onPrev: function() {
				setTimeout(function() {
					$('.flex_scroll').scrollTop(200);
				},100);
			}
    },
	{
      target: 'tour_crt_relate',
      title: _('Task Relate'),
      content: _('Establish relationship between tasks. Such as<br /><br /><b>Relates to</b>: This shows the intended task is related to the following \'Linking Task\'.<br /><b>Duplicated by</b>: This shows the intended task is a duplicated task of an existing task.<br /><b>Derived from</b>: This shows the intended task is derived or an outcome of an existing task.'),
      placement: 'bottom',
			yOffset: -4,
			width: 390,
      arrowOffset: 70,
			delay: 100,
    },
	{
      target: 'tour_crt_linking',
      title: _('Task Linking'),
      content: _('Link associated tasks for better clarity'),
      placement: 'bottom',
			yOffset: -4,
      arrowOffset: 70,
			delay: 100
    },	
	{
      target: 'tour_crt_label',
      title: _('Task Label'),
      content: _('Tag a task with a label(s)'),
      placement: 'bottom',
			yOffset: -4,
      arrowOffset: 70,
			onNext: function() {
				setTimeout(function() {
					$('.flex_scroll').scrollTop(370);
				},100);
			},
			onPrev: function() {
				setTimeout(function() {
					$('.flex_scroll').scrollTop(250);
				},100);
			}
    },
	{
      target: 'tour_crt_notify_v2',
      title: _('Notify Other Users'),
      content: _('Send notifications about the task to all team members.'),
      placement: 'right',
			delay: 100,
			width: 220,
	  //yOffset: -15,
      //arrowOffset: 70
    },
	/*{
      target: 'tour_crt_client',
      title: 'Private Task?',
      content: 'Check here to hide task from your clients.',
      placement: 'bottom',
	  yOffset: -15,
      arrowOffset: 70
    },*/
	{
      target: 'tour_crt_post',
      title: _('Create Task'),
      content: _("You're good to go! Click on Save & Continue to create another task."),
      placement: 'top',
	  //yOffset: -4,
      //arrowOffset: 150
    },	
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};
/*tour_taskdtl in dashboard v1 js for task detail page*/
var tour_project = {
  id: 'hello-hopscotch',
  steps: [
    {
      target: 'tour_crt_proj_btn',
      title: _('Create Project'),
      content: _('Click here to create a New Project.'),
      placement: 'left',
	  yOffset: -5,
      arrowOffset: 2
    },  
	{
      target: 'tour_crt_proj_swtch',
      title: _('Quick Filter'),
      content: _('Navigate Projects across various status.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 70
    },{
      target: 'tour_proj_srch',
      title: _('Search Project'),
      content: _('Quick search for projects.'),
      placement: 'right',
	  yOffset: -18,
	  xOffset: 20,
      //arrowOffset: 70
    },{
      target: 'tour_proj_view',
      title: _('Project View'),
      content: _('Set how your project to look; "Card View" or "List View".'),
      placement: 'left',
	  //yOffset: -5,
     // arrowOffset: 70
    },{
      target: 'tour_proj_sts',
      title: _('Project Status'),
      content: _('Displays current status of the Project.'),
      placement: 'top',
	  xOffset: -15,
      //arrowOffset: 100
    },{
      target: 'tour_proj_shortnm',
      title: _('Project Short Name'),
      content: _('Your Project Short Name created during the Project.'),
      placement: 'bottom',
	  yOffset: -9,
      //arrowOffset: 70
    },{
      target: 'tour_proj_crtdon',
      title: _('Created On'),
      content: _('The date when you\'ve created the project.'),
      placement: 'right',
	  yOffset: -18,
      //arrowOffset: 70
    },{
      target: 'tour_proj_prio',
      title: _('Project Priority'),
      content: _('Shows the priority of the project.'),
      placement: 'right',
	  yOffset: -35,
      //arrowOffset: 70
    },{
      target: 'tour_proj_actn',
      title: _('Other Actions'),
      content: _('Perform actions like Add or Remove User, Edit Project, mark project as Complete.'),
      placement: 'right',
	  yOffset: -15,
      //arrowOffset: 70
    },
	{
      target: 'tour_proj_invlv',
      title: _('Team Involved'),
      content: _('Shows all the stakeholders involved in the project.'),
      placement: 'right',
	  yOffset: -10,
      //arrowOffset: 70
    },
	{
      target: 'tour_proj_infos',
      title: _('Project Key Information'),
      content: _('Shows total tasks, time spent& storage space --on this project.'),
      placement: 'right',
	  yOffset: -5,
      //arrowOffset: 40
    },
	{
      target: 'tour_proj_renhr',
      title: _('Remaining Hours'),
      content: _('Know how many hours left for your project launch.'),
      placement: 'bottom',
	  yOffset: -5,
      arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};


var tour_crtproj = {
  id: 'hello-hopscotch',
  steps: [
    {
      target: 'txt_Proj',
      title: _('Project Name'),
      content: _('Provide a meaningful name for your Project.'),
      placement: 'bottom',
			delay: 1000,
			width: 220,
	  //yOffset: -5,
     // arrowOffset: 2
    },  
	{
      target: 'txt_shortProj',
      title: _('Project Short Name'),
      content: _('Define a unique short name for project for reference. Alphanumeric entry with max 5 characters.'),
      placement: 'bottom',
	  //yOffset: -3,
      //arrowOffset: 70
    },{
      target: 'priority_dropdown',
      title: _('Priority'),
      content: _('Set appropriate Priority - Low, Medium or High to your project.'),
      placement: 'bottom',
	  //yOffset: -18,
	  //xOffset: 20,
      //arrowOffset: 70
    },{
      target: 'task_type',
      title: _('Default Task Type'),
      content: _('Set the default task type for each task, e.g., Development or Bug'),
      placement: 'bottom',
	  //yOffset: -5,
     // arrowOffset: 70
    },{
      target: 'tmpl_dropdown',
      title: _('Add Project Plan'),
      content: _('Select a pre-defined Project Plan or, Create a new'),
      placement: 'bottom',
	  //yOffset: -11,
      //arrowOffset: 100
    },{
      target: 'prj_desc',
      title: _('Add Descriptions'),
      content: _('Write a brief about the project is all about.'),
      placement: 'bottom',
	  yOffset: -9,
      //arrowOffset: 70
    },
		/*{
      target: 'members_list',
      title: _('Invite Users'),
      content: _('Invite your team members and customer who will be part of the project.'),
      placement: 'right',
			yOffset: -5,
			width: 240,
      //arrowOffset: 70
    },*/
		{
      target: 'more_proj_options_new',
      title: _('Define Project Durations'),
      content: _('Time-box your project to track timely completion.'),
      placement: 'right',
			yOffset: 20,
			width: 240,
      //arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};
var tour_invtuser = {
  id: 'hello-hopscotch',
  steps: [
    {
      target: 'txt_email',
      title: _('Add Users'),
      content: _('Enter Email ids to add users. Use comma as separator to invite multiple users at a time.'),
      placement: 'bottom',
	  //yOffset: -5,
     // arrowOffset: 2
    },  
	{
      target: 'tour_impt_contact',
      title: _('Import Contacts'),
      content: _('Click to add all your Google Contacts to Orangescrum.'),
      placement: 'bottom',
	  //yOffset: -3,
      //arrowOffset: 70
    },{
      target: 'tour_asnproj_user',
      title: _('Assign Projects'),
      content: _('Type Project Name to assign project to the user.'),
      placement: 'bottom',
	  //yOffset: -18,
	  //xOffset: 20,
      //arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};
var tour_invtuser_no_project = {
  id: 'hello-hopscotch',
  steps: [
    {
      target: 'txt_email',
      title: _('Add Users'),
      content: _('Enter Email ids to add users. Use comma as separator to invite multiple users at a time.'),
      placement: 'bottom',
    //yOffset: -5,
     // arrowOffset: 2
    },  
  {
      target: 'tour_impt_contact',
      title: _('Import Contacts'),
      content: _('Click to add all your Google Contacts to Orangescrum.'),
      placement: 'bottom',
    //yOffset: -3,
      //arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};
var tour_user = {
  id: 'hello-hopscotch',
  steps: [
	{
      target: 'tour_invt_user_btn',
      title: _('Add/Invite New User'),
      content: _('Click here to add/invite new user.'),
      placement: 'left',
	  yOffset: -5,
      arrowOffset: 2
    },
    {
      target: 'tour_actv_user',
      title: _('Active User'),
      content: _('All active users in your Orangescrum account.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 5
    },  
	{
      target: 'tour_invt_user',
      title: _('Invited User'),
      content: _('All invited users who’ve not Signed up yet.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 5
    },{
      target: 'tour_clint_user',
      title: _('Client User'),
      content: _('List of all client users'),
      placement: 'right',
	  yOffset: -18,
	  xOffset: 10,
      //arrowOffset: 70
    },{
      target: 'tour_disbl_user',
      title: _('Disable User'),
      content: _('All disabled users. These users can’t access Orangescrum anymore.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 5,
    },{
      target: 'tour_proj_srch',
      title: _('Search User'),
      content: _('Search a particular user from here.'),
      placement: 'right',
	  yOffset: -18,
	  xOffset: 20,
    },{
      target: 'tour_role_user',
      title: _('User Role'),
      content: _('Shows the assigned role (Owner, Admin, User, Client) of the user in the application.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 2,
    },{
      target: 'tour_info_user',
      title: _('User Information'),
      content: _('The user card shows the User Name, Role, Email id, Last Activity Date.'),
      placement: 'right',
	  yOffset: -25,
      //arrowOffset: 70
    },{
      target: 'tour_projs_user',
      title: _('Projects Assigned'),
      content: _('Shows the assigned Projects.'),
      placement: 'right',
	  yOffset: -5,
      //arrowOffset: 70
    },{
      target: 'tour_acton_user',
      title: _('Other Actions'),
      content: _('Assign or remove projects, grant or revoke admin or client access or disable user here.'),
      placement: 'right',
	  yOffset: -20,
      //arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};

/*-----German start here-----*/
var tour_deu = {
  id: 'hello-hopscotch',
  i18n: {
	nextBtn: "Nächster",
	prevBtn: "Zurück",
	doneBtn: "erledigt",
	skipBtn: "überspringen",
	closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'new_onboarding_add_icon',
      title: _('Aufgabe erstellen'),
      content: _('Fügen Sie Ihrem soeben erstellten Projekt Aufgaben hinzu, und weisen Sie die Zusammenarbeit zu ...'),
      placement: 'bottom',
			yOffset: -18,
      arrowOffset: 7
    },
	{
      target: 'no-task-crt-task',
      title: _('Neue Aufgabe erstellen'),
      content: _('Hinzufügen von Aufgaben zu Ihren Projekten, Zuweisen und Zusammenarbeiten ...'),
      placement: 'bottom',
      arrowOffset: 30
    },
	{
      target: 'new_task_label',
      placement: 'bottom',
      title: _('Schnelle Aufgabe'),
      content: _('Aufgabe schnell erstellen - Geben Sie Fälligkeitsdatum, Aufgabentyp, Zuweisung und geschätzte Stunde ein'),
      yOffset: -4,
	  arrowOffset: 20
    },
    {
      target: 'no-task-impt-task',
      placement: 'bottom',
      title: _('Migration von woanders?'),
      content: _('Klicken Sie hier, um alle Ihre Aufgaben in Orangescrum zu importieren ...'),
      yOffset: -7
    },
    {
      target: 'left_menu_nav_tour',
      title: _('Einfache Navigation'),
      content: _('Navigieren Sie schnell zwischen "Meine Aufgabe", "Überfällig" und andere'),
      placement: 'right',
      //xOffset: -15,
	  //yOffset: -10
	  arrowOffset: 10
    },
    {
      target: 'task_filter',
      placement: 'left',
      title: _('Filter anwenden'),
      content: _('Filtern Sie, indem Sie Ihre Suche eingrenzen. Speichern Sie den Filter zum schnellen Nachschlagen'),
      yOffset: -15,
	  xOffset: 10,
	  arrowOffset: 1
    },
    {
      target: 'ajaxCaseStatus',
      placement: 'bottom',
      title: _('Schnellfilter: Taskstatus'),
      content: _('Differenzieren Sie Aufgaben nach ihrem Status'),
      //yOffset: -17
	  arrowOffset: 24
    },
    {
      target: 'topactions',
      placement: 'bottom',
      title: _('Zugriff auf andere Aufgabenansicht?'),
      content: _('Greifen Sie auf die bevorzugte Aufgabenansicht zu - Aufgabenliste / Aufgabengruppe / Kanban- oder Kalenderansicht'),
      xOffset: 54,
	  yOffset: 5,
      arrowOffset: 75,
    },
    {
      target: 'task_impExp',
      placement: 'left',
      title: _('Aufgaben exportieren'),
      content: _('Aufgaben in CSV / PDF exportieren'),
	  yOffset: -15,
	  xOffset: 5,
	  arrowOffset: 1
    },    
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};


var tour_crttask_deu = {
  id: 'hello-hopscotch',
  i18n: {
	nextBtn: "Nächster",
	prevBtn: "Zurück",
	doneBtn: "erledigt",
	skipBtn: "überspringen",
	closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'CS_title',
      title: _('Aufgabentitel'),
      content: _('Benennen Sie die zu erstellende Aufgabe'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },
	/*{
      target: 'CS_parent_task',
      title: _('Parent Task'),
      content: _('Select a parent task to create subtask.'),
      placement: 'bottom',
	  yOffset: 25,
      arrowOffset: 70
    },*/	
	{
      target: 'tour_crt_asign',
      title: _('Zuweisen'),
      content: _("Wählen Sie den Benutzer aus, an dem Sie arbeiten möchten"),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_type',
      title: _('Aufgabentyp'),
      content: _('Task am besten klassifizieren, um vordefinierte Aufgabentypen zu verstehen oder auszuwählen (z. B. Entwicklung, Fehler)'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_prio',
      title: _('Priorität setzen'),
      content: _('Legen Sie hier die Priorität fest'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_desc',
      title: _('Aufgabenbeschreibung'),
      content: _('Eine Beschreibung der Aufgabe. Wählen Sie für sich wiederholende Aufgaben einfach die Vorlage aus'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_attach',
      title: _('Dateien anhängen'),
      content: _('Ziehen Sie Ihre Dateien in diesen Bereich. Dateien von Dropbox / Google-Laufwerk können ebenfalls angehängt werden'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_srtend',
      title: _('Start- und Enddatum'),
      content: _('Setzen Sie ein Zeitfenster für Ihre Aufgabe, um den Überblick zu behalten'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_tskgrp',
      title: _('Aufgabengruppe'),
      content: _('Ermöglicht die Gruppierung ähnlicher Aufgaben'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_estmtd',
      title: _('Geschätzte Stunden'),
      content: _('Legen Sie die geplante Zeit für den Abschluss der Aufgabe fest﻿'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },
	{
      target: 'tour_crt_timrng',
      title: _('Zeitspanne'),
      content: _('Definieren Sie einen bestimmten Zeitraum für die Aufgabe einschließlich der Pause. Verbrauchte Stunden werden automatisch berechnet'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },
	{
      target: 'tour_crt_recur',
      title: _('Wiederkehrend'),
      content: _('Wiederholen Sie die Aufgabe pro Frequenz - Täglich, Wöchentlich, Monatlich oder Jährlich'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_isbil',
      title: _('Ist abrechenbar?'),
      content: _('Markieren Sie die Aufgabe, wenn Kosten verbunden sind'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },
	{
      target: 'tour_crt_relate',
      title: _('Aufgabenstellung'),
      content: _('Dies hilft, sich auf eine Aufgabe zu beziehen. Sowie<br /><br /><b>Bezieht sich auf</b>: Dies zeigt, dass die beabsichtigte Aufgabe mit dem Folgenden zusammenhängt \'Verknüpfungstask\'.<br /><b>Dupliziert von</b>: Dies zeigt, dass die beabsichtigte Aufgabe eine duplizierte Aufgabe einer vorhandenen Aufgabe ist.<br /><b>Abgeleitet von</b>: Dies zeigt, dass die beabsichtigte Aufgabe abgeleitet ist oder ein Ergebnis einer vorhandenen Aufgabe ist.'),
      placement: 'bottom',
	  yOffset: -4,
      arrowOffset: 70
    },
	{
      target: 'tour_crt_linking',
      title: _('Aufgabenverknüpfung'),
      content: _('Fügen Sie die Aufgabe hinzu, zu der Sie einen Link erstellen möchten'),
      placement: 'bottom',
	  yOffset: -4,
      arrowOffset: 70
    },	
	{
      target: 'tour_crt_label',
      title: _('Aufgabenbezeichnung'),
      content: _('Eine Aufgabe mit einem Etikett kennzeichnen'),
      placement: 'bottom',
	  yOffset: -4,
      arrowOffset: 70
    },
	{
      target: 'tour_crt_notify',
      title: _('Andere Benutzer benachrichtigen'),
      content: _('Senden Sie Benachrichtigungen über die Aufgabe an alle Teammitglieder.'),
      placement: 'right',
	  //yOffset: -15,
      //arrowOffset: 70
    },
	/*{
      target: 'tour_crt_client',
      title: 'Private Task?',
      content: 'Check here to hide task from your clients.',
      placement: 'bottom',
	  yOffset: -15,
      arrowOffset: 70
    },*/
	{
      target: 'tour_crt_post',
      title: _('Aufgabe erstellen'),
      content: _("Du bist gut zu gehen! Klicken Sie auf Speichern und fortfahren, um eine weitere Aufgabe zu erstellen."),
      placement: 'top',
	  //yOffset: -4,
      //arrowOffset: 150
    },	
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};

var tour_project_deu = {
  id: 'hello-hopscotch',
  i18n: {
	nextBtn: "Nächster",
	prevBtn: "Zurück",
	doneBtn: "erledigt",
	skipBtn: "überspringen",
	closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'tour_crt_proj_btn',
      title: _('Projekt erstellen'),
      content: _('Klicken Sie hier, um ein neues Projekt zu erstellen.'),
      placement: 'left',
	  yOffset: -5,
      arrowOffset: 2
    },  
	{
      target: 'tour_crt_proj_swtch',
      title: _('Schnellfilter'),
      content: _('Projekte über verschiedene Status hinweg navigieren.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 70
    },{
      target: 'tour_proj_srch',
      title: _('Projekt suchen'),
      content: _('Schnelle Suche nach Projekten.'),
      placement: 'right',
	  yOffset: -18,
	  xOffset: 20,
      //arrowOffset: 70
    },{
      target: 'tour_proj_view',
      title: _('Projektansicht'),
      content: _('Legen Sie fest, wie Ihr Projekt aussehen soll. "Kartenansicht" oder "Listenansicht".'),
      placement: 'left',
	  //yOffset: -5,
     // arrowOffset: 70
    },{
      target: 'tour_proj_sts',
      title: _('Projekt-Status'),
      content: _('Zeigt den aktuellen Status des Projekts an.'),
      placement: 'top',
	  xOffset: -15,
      //arrowOffset: 100
    },{
      target: 'tour_proj_shortnm',
      title: _('Kurzname des Projekts'),
      content: _('Ihr Projektkurzname, der während des Projekts erstellt wurde.'),
      placement: 'bottom',
	  yOffset: -9,
      //arrowOffset: 70
    },{
      target: 'tour_proj_crtdon',
      title: _('Erstellt am'),
      content: _('Das Datum, an dem Sie das Projekt erstellt haben.'),
      placement: 'right',
	  yOffset: -18,
      //arrowOffset: 70
    },{
      target: 'tour_proj_prio',
      title: _('Projektpriorität'),
      content: _('Zeigt die Priorität des Projekts an.'),
      placement: 'right',
	  yOffset: -35,
      //arrowOffset: 70
    },{
      target: 'tour_proj_actn',
      title: _('Andere Aktionen'),
      content: _('Führen Sie Aktionen aus, wie z. B. Benutzer hinzufügen oder entfernen, Projekt bearbeiten, Projekt als abgeschlossen markieren.'),
      placement: 'right',
	  yOffset: -15,
      //arrowOffset: 70
    },
	{
      target: 'tour_proj_invlv',
      title: _('Team beteiligt'),
      content: _('Zeigt alle am Projekt beteiligten Stakeholder.'),
      placement: 'right',
	  yOffset: -10,
      //arrowOffset: 70
    },
	{
      target: 'tour_proj_infos',
      title: _('Projektschlüsselinformationen'),
      content: _('Zeigt die Gesamtaufgaben, Zeit und Speicherplatz an - für dieses Projekt.'),
      placement: 'right',
	  yOffset: -5,
      //arrowOffset: 40
    },
	{
      target: 'tour_proj_renhr',
      title: _('Restliche Stunden'),
      content: _('Erfahren Sie, wie viele Stunden bis zum Start Ihres Projekts noch verfügbar sind.'),
      placement: 'bottom',
	  yOffset: -5,
      arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};


var tour_crtproj_deu = {
  id: 'hello-hopscotch',
  i18n: {
	nextBtn: "Nächster",
	prevBtn: "Zurück",
	doneBtn: "erledigt",
	skipBtn: "überspringen",
	closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'txt_Proj',
      title: _('Projektname'),
      content: _('Geben Sie Ihrem Projekt einen aussagekräftigen Namen.'),
      placement: 'bottom',
			delay: 1000,
	  //yOffset: -5,
     // arrowOffset: 2
    },  
	{
      target: 'txt_shortProj',
      title: _('Kurzname des Projekts'),
      content: _('Definieren Sie einen eindeutigen Kurznamen für das Projekt als Referenz. Alphanumerischer Eintrag mit maximal 5 Zeichen.'),
      placement: 'bottom',
	  //yOffset: -3,
      //arrowOffset: 70
    },{
      target: 'priority_dropdown',
      title: _('Priorität'),
      content: _('Stellen Sie die geeignete Priorität - Niedrig, Mittel oder Hoch für Ihr Projekt ein.'),
      placement: 'bottom',
	  //yOffset: -18,
	  //xOffset: 20,
      //arrowOffset: 70
    },{
      target: 'task_type',
      title: _('Standardaufgabentyp'),
      content: _('Legen Sie den Standard-Aufgabentyp für jede Aufgabe fest, beispielsweise Entwicklung oder Fehler'),
      placement: 'bottom',
	  //yOffset: -5,
     // arrowOffset: 70
    },{
      target: 'tmpl_dropdown',
      title: _('Projektvorlage hinzufügen'),
      content: _('Wählen Sie eine vordefinierte Projektvorlage oder Erstellen Sie eine neue'),
      placement: 'bottom',
	  //yOffset: -11,
      //arrowOffset: 100
    },{
      target: 'prj_desc',
      title: _('Beschreibungen hinzufügen'),
      content: _('Schreiben Sie eine kurze Beschreibung des Projekts.'),
      placement: 'bottom',
	  yOffset: -9,
      //arrowOffset: 70
	},/*{
      target: 'members_list',
      title: _('Benutzer einladen'),
      content: _('Laden Sie Ihre Teammitglieder und Kunden ein, die Teil des Projekts sein werden.'),
      placement: 'right',
			yOffset: -5,
			width: 240,
      //arrowOffset: 70
    },*/{
      target: 'more_proj_options_new',
      title: _('Projektdauer definieren'),
      content: _('Setzen Sie ein Zeitfenster für Ihr Projekt ein, um die rechtzeitige Fertigstellung zu verfolgen.'),
      placement: 'right',
			yOffset: 20,
			width: 240,
      //arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};
var tour_invtuser_deu = {
  id: 'hello-hopscotch',
  i18n: {
	nextBtn: "Nächster",
	prevBtn: "Zurück",
	doneBtn: "erledigt",
	skipBtn: "überspringen",
	closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'txt_email',
      title: _('Benutzer hinzufügen'),
      content: _('Geben Sie die E-Mail-IDs ein, um Benutzer hinzuzufügen. Verwenden Sie das Komma als Trennzeichen, um mehrere Benutzer gleichzeitig einzuladen.'),
      placement: 'bottom',
	  //yOffset: -5,
     // arrowOffset: 2
    },  
	{
      target: 'tour_impt_contact',
      title: _('Kontakte importieren'),
      content: _('Klicken Sie hier, um alle Ihre Google-Kontakte zu Orangescrum hinzuzufügen.'),
      placement: 'bottom',
	  //yOffset: -3,
      //arrowOffset: 70
    },{
      target: 'tour_asnproj_user',
      title: _('Projekte zuordnen'),
      content: _('Geben Sie Projektname ein, um dem Benutzer ein Projekt zuzuweisen.'),
      placement: 'bottom',
	  //yOffset: -18,
	  //xOffset: 20,
      //arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};
var tour_invtuser_no_project_deu = {
  id: 'hello-hopscotch',
  i18n: {
  nextBtn: "Nächster",
  prevBtn: "Zurück",
  doneBtn: "erledigt",
  skipBtn: "überspringen",
  closeTooltip: "schließen",
  //stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'txt_email',
      title: _('Benutzer hinzufügen'),
      content: _('Geben Sie die E-Mail-IDs ein, um Benutzer hinzuzufügen. Verwenden Sie das Komma als Trennzeichen, um mehrere Benutzer gleichzeitig einzuladen.'),
      placement: 'bottom',
    //yOffset: -5,
     // arrowOffset: 2
    },  
  {
      target: 'tour_impt_contact',
      title: _('Kontakte importieren'),
      content: _('Klicken Sie hier, um alle Ihre Google-Kontakte zu Orangescrum hinzuzufügen.'),
      placement: 'bottom',
    //yOffset: -3,
      //arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};
var tour_user_deu = {
  id: 'hello-hopscotch',
  i18n: {
	nextBtn: "Nächster",
	prevBtn: "Zurück",
	doneBtn: "erledigt",
	skipBtn: "überspringen",
	closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
	{
      target: 'tour_invt_user_btn',
      title: _('Neuen Benutzer hinzufügen / einladen'),
      content: _('Klicken Sie hier, um einen neuen Benutzer hinzuzufügen / einzuladen.'),
      placement: 'left',
	  yOffset: -5,
      arrowOffset: 2
    },
    {
      target: 'tour_actv_user',
      title: _('Aktiver Nutzer'),
      content: _('Alle aktiven Benutzer in Ihrem Orangescrum-Konto.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 5
    },  
	{
      target: 'tour_invt_user',
      title: _('Eingeladener Benutzer'),
      content: _('Alle eingeladenen Benutzer, die noch nicht angemeldet sind.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 5
    },{
      target: 'tour_clint_user',
      title: _('Client-Benutzer'),
      content: _('Liste aller Clientbenutzer'),
      placement: 'right',
	  yOffset: -18,
	  xOffset: 10,
      //arrowOffset: 70
    },{
      target: 'tour_disbl_user',
      title: _('Benutzer deaktivieren'),
      content: _('Alle deaktivierten Benutzer Diese Benutzer können nicht mehr auf Orangescrum zugreifen.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 5,
    },{
      target: 'tour_proj_srch',
      title: _('Benutzer suchen'),
      content: _('Suchen Sie einen bestimmten Benutzer von hier aus.'),
      placement: 'right',
	  yOffset: -18,
	  xOffset: 20,
    },{
      target: 'tour_role_user',
      title: _('Benutzer-Rolle'),
      content: _('Zeigt die zugewiesene Rolle (Eigentümer, Admin, Benutzer, Client) des Benutzers in der Anwendung an.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 2,
    },{
      target: 'tour_info_user',
      title: _('Nutzerinformation'),
      content: _('Die Benutzerkarte zeigt den Benutzernamen, die Rolle, die E-Mail-ID und das Datum der letzten Aktivität an.'),
      placement: 'right',
	  yOffset: -25,
      //arrowOffset: 70
    },{
      target: 'tour_projs_user',
      title: _('Zugeordnete Projekte'),
      content: _('Zeigt die zugewiesenen Projekte.'),
      placement: 'right',
	  yOffset: -5,
      //arrowOffset: 70
    },{
      target: 'tour_acton_user',
      title: _('Andere Aktionen'),
      content: _('Projekte zuweisen oder entfernen, Administrator- oder Clientzugriff gewähren oder widerrufen oder Benutzer hier deaktivieren.'),
      placement: 'right',
	  yOffset: -20,
      //arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};

/*-----German end here-----*/

/*-----Spanish start-----*/
var tour_spa = {
  id: 'hello-hopscotch',
  i18n: {
	nextBtn: "Siguiente",
	prevBtn: "Espalda",
	doneBtn: "Hecho",
	skipBtn: "Omitir",
	//closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'new_onboarding_add_icon',
      title: _('Crear tarea'),
      content: _('Agregue tareas al proyecto que acaba de crear, luego asigne y comience a colaborar ...'),
      placement: 'bottom',
	  yOffset: -18,
      arrowOffset: 7
    },
	{
      target: 'no-task-crt-task',
      title: _('Crear nueva tarea'),
      content: _('Agrega tareas a tus proyectos, asigna y colabora ...'),
      placement: 'bottom',
      arrowOffset: 30
    },
	{
      target: 'new_task_label',
      placement: 'bottom',
      title: _('Tarea rápida'),
      content: _('Cree la tarea rápidamente: ingrese Fecha de vencimiento, Tipo de tarea, Asignar a y Hora estimada'),
      yOffset: -4,
	  arrowOffset: 20
    },
    {
      target: 'no-task-impt-task',
      placement: 'bottom',
      title: _('¿Emigrando desde otro lugar?'),
      content: _('Haga clic aquí para importar todas sus tareas en Orangescrum ...'),
      yOffset: -7
    },
    {
      target: 'left_menu_nav_tour',
      title: _('Fácil navegación'),
      content: _('Navega rápidamente entre Mi tarea, Vencidos y otros'),
      placement: 'right',
      //xOffset: -15,
	  //yOffset: -10
	  arrowOffset: 10
    },
    {
      target: 'task_filter',
      placement: 'left',
      title: _('Aplicar filtro'),
      content: _('Filtrar por la reducción de su búsqueda. Guarde su filtro para una referencia rápida'),
      yOffset: -15,
	  xOffset: 10,
	  arrowOffset: 1
    },
    {
      target: 'ajaxCaseStatus',
      placement: 'bottom',
      title: _('Filtro rápido: Estado de la tarea'),
      content: _('Diferencia las tareas en función de su estado.'),
      //yOffset: -17
	  arrowOffset: 24
    },
    {
      target: 'topactions',
      placement: 'bottom',
      title: _('¿Acceso a la vista de diferentes tareas?'),
      content: _('Acceda a la vista de tareas preferida: Lista de tareas / Grupo de tareas / Kanban o Vista de calendario'),
      xOffset: 54,
	  yOffset: 5,
      arrowOffset: 75,
    },
    {
      target: 'task_impExp',
      placement: 'left',
      title: _('Tareas de exportación'),
      content: _('Exportar tareas en CSV / PDF'),
	  yOffset: -15,
	  xOffset: 5,
	  arrowOffset: 1
    },    
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};


var tour_crttask_spa = {
  id: 'hello-hopscotch',
   i18n: {
	nextBtn: "Siguiente",
	prevBtn: "Espalda",
	doneBtn: "Hecho",
	skipBtn: "Omitir",
	//closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'CS_title',
      title: _('Título de la tarea'),
      content: _('Nombra la tarea a crear'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },
	/*{
      target: 'CS_parent_task',
      title: _('Parent Task'),
      content: _('Select a parent task to create subtask.'),
      placement: 'bottom',
	  yOffset: 25,
      arrowOffset: 70
    },*/	
	{
      target: 'tour_crt_asign',
      title: _('Asignar a'),
      content: _("Selecciona el usuario para trabajar en ello."),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_type',
      title: _('Tipo de tarea'),
      content: _('Clasifique la tarea mejor entendida o seleccione un tipo de tarea predefinida (por ejemplo, Desarrollo, Error)'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_prio',
      title: _('Fijar prioridad'),
      content: _('Define la prioridad aquí'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_desc',
      title: _('Descripción de la tarea'),
      content: _('Un poco de descripción sobre la tarea. Para tareas repetitivas, simplemente seleccione la plantilla'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_attach',
      title: _('Adjuntar archivos'),
      content: _('Drag and Drop your files upon this area. Files from Dropbox/Google drive can be attached too'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_srtend',
      title: _('Fecha de inicio y finalización'),
      content: _('Time-box su tarea para realizar un seguimiento de ella'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_tskgrp',
      title: _('Tarea grupal'),
      content: _('Permite agrupar tareas similares.'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_estmtd',
      title: _('Horas estimadas'),
      content: _('Establecer el tiempo previsto para la finalización de la tarea.'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },
	{
      target: 'tour_crt_timrng',
      title: _('Intervalo de tiempo'),
      content: _('Defina un rango de tiempo específico para la tarea, incluyendo el descanso; Las horas gastadas se calcularán automáticamente'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },
	{
      target: 'tour_crt_recur',
      title: _('Periódico'),
      content: _('Repetir tareas por frecuencia: diaria, semanal, mensual o anual'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_isbil',
      title: _('Es facturable?'),
      content: _('Marque la tarea si el costo asociado'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },
	{
      target: 'tour_crt_relate',
      title: _('Relación de tarea'),
      content: _("Esto ayuda a referirse a una tarea a otra. Como<br /><br /><b>Se relaciona con</b>: Esto muestra que la tarea prevista está relacionada con lo siguiente \'Tarea de vinculación\'.<br /><b>Duplicado por</b>: Esto muestra que la tarea prevista es una tarea duplicada de una tarea existente.<br /><b>Derivado de</b>: Esto muestra que la tarea deseada se deriva o el resultado de una tarea existente."),
      placement: 'bottom',
	  yOffset: -4,
      arrowOffset: 70
    },
	{
      target: 'tour_crt_linking',
      title: _('Vinculación de tareas'),
      content: _('Agregue la tarea a la que desea vincular'),
      placement: 'bottom',
	  yOffset: -4,
      arrowOffset: 70
    },	
	{
      target: 'tour_crt_label',
      title: _('Etiqueta de tarea'),
      content: _('Etiqueta una tarea con una etiqueta (s)'),
      placement: 'bottom',
	  yOffset: -4,
      arrowOffset: 70
    },
	{
      target: 'tour_crt_notify',
      title: _('Notificar a otros usuarios'),
      content: _('Enviar notificaciones sobre la tarea a todos los miembros del equipo.'),
      placement: 'right',
	  //yOffset: -15,
      //arrowOffset: 70
    },
	/*{
      target: 'tour_crt_client',
      title: 'Private Task?',
      content: 'Check here to hide task from your clients.',
      placement: 'bottom',
	  yOffset: -15,
      arrowOffset: 70
    },*/
	{
      target: 'tour_crt_post',
      title: _('Crear tarea'),
      content: _("¡Eres bueno para ir! Haga clic en Guardar y continuar para crear otra tarea."),
      placement: 'top',
	  //yOffset: -4,
      //arrowOffset: 150
    },	
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};
var tour_project_spa = {
  id: 'hello-hopscotch',
   i18n: {
	nextBtn: "Siguiente",
	prevBtn: "Espalda",
	doneBtn: "Hecho",
	skipBtn: "Omitir",
	//closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'tour_crt_proj_btn',
      title: _('Crear proyecto'),
      content: _('Haga clic aquí para crear un nuevo proyecto.'),
      placement: 'left',
	  yOffset: -5,
      arrowOffset: 2
    },  
	{
      target: 'tour_crt_proj_swtch',
      title: _('Filtro rápido'),
      content: _('Navegar proyectos a través de varios estados.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 70
    },{
      target: 'tour_proj_srch',
      title: _('Proyecto de búsqueda'),
      content: _('Quick search your projects.'),
      placement: 'right',
	  yOffset: -18,
	  xOffset: 20,
      //arrowOffset: 70
    },{
      target: 'tour_proj_view',
      title: _('Vista del proyecto'),
      content: _('Establece cómo se verá tu proyecto; "Vista de tarjeta" o "Vista de lista".'),
      placement: 'left',
	  //yOffset: -5,
     // arrowOffset: 70
    },{
      target: 'tour_proj_sts',
      title: _('Estado del proyecto'),
      content: _('Muestra el estado actual del proyecto.'),
      placement: 'top',
	  xOffset: -15,
      //arrowOffset: 100
    },{
      target: 'tour_proj_shortnm',
      title: _('Nombre corto del proyecto'),
      content: _('Su nombre corto del proyecto creado durante el proyecto.'),
      placement: 'bottom',
	  yOffset: -9,
      //arrowOffset: 70
    },{
      target: 'tour_proj_crtdon',
      title: _('Creado en'),
      content: _('La fecha en la que has creado el proyecto.'),
      placement: 'right',
	  yOffset: -18,
      //arrowOffset: 70
    },{
      target: 'tour_proj_prio',
      title: _('Prioridad del proyecto'),
      content: _('Muestra la prioridad del proyecto.'),
      placement: 'right',
	  yOffset: -35,
      //arrowOffset: 70
    },{
      target: 'tour_proj_actn',
      title: _('Otras acciones'),
      content: _('Realice acciones como Agregar o quitar usuarios, Editar proyecto, marcar proyecto como Completo.'),
      placement: 'right',
	  yOffset: -15,
      //arrowOffset: 70
    },
	{
      target: 'tour_proj_invlv',
      title: _('Equipo involucrado'),
      content: _('Muestra todos los actores involucrados en el proyecto.'),
      placement: 'right',
	  yOffset: -10,
      //arrowOffset: 70
    },
	{
      target: 'tour_proj_infos',
      title: _('Información Clave del Proyecto'),
      content: _('Muestra las tareas totales, el tiempo empleado y el espacio de almacenamiento - en este proyecto.'),
      placement: 'right',
	  yOffset: -5,
      //arrowOffset: 40
    },
	{
      target: 'tour_proj_renhr',
      title: _('Horas restantes'),
      content: _('Sepa cuántas horas faltan para el lanzamiento de su proyecto.'),
      placement: 'bottom',
	  yOffset: -5,
      arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};


var tour_crtproj_spa = {
  id: 'hello-hopscotch',
   i18n: {
	nextBtn: "Siguiente",
	prevBtn: "Espalda",
	doneBtn: "Hecho",
	skipBtn: "Omitir",
	//closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'txt_Proj',
      title: _('Nombre del proyecto'),
      content: _('Proporcione un nombre significativo para su proyecto.'),
      placement: 'bottom',
			delay: 1000,
	  //yOffset: -5,
     // arrowOffset: 2
    },  
	{
      target: 'txt_shortProj',
      title: _('Nombre corto del proyecto'),
      content: _('Defina un nombre corto único para el proyecto como referencia. Entrada alfanumérica con un máximo de 5 caracteres.'),
      placement: 'bottom',
	  //yOffset: -3,
      //arrowOffset: 70
    },{
      target: 'priority_dropdown',
      title: _('Prioridad'),
      content: _('Establezca la prioridad adecuada: baja, media o alta para su proyecto.'),
      placement: 'bottom',
	  //yOffset: -18,
	  //xOffset: 20,
      //arrowOffset: 70
    },{
      target: 'task_type',
      title: _('Tipo de tarea predeterminado'),
      content: _('Establezca el tipo de tarea predeterminado para cada tarea, por ejemplo, Desarrollo o Error'),
      placement: 'bottom',
	  //yOffset: -5,
     // arrowOffset: 70
    },{
      target: 'tmpl_dropdown',
      title: _('Añadir plantilla de proyecto'),
      content: _('Seleccione una plantilla de proyecto predefinida o, Crear una nueva'),
      placement: 'bottom',
	  //yOffset: -11,
      //arrowOffset: 100
    },{
      target: 'prj_desc',
      title: _('Añadir descripciones'),
      content: _('Escribir un breve sobre el proyecto se trata.'),
      placement: 'bottom',
	  yOffset: -9,
      //arrowOffset: 70
	},/*{
      target: 'members_list',
      title: _('Invitar a los usuarios'),
      content: _('Invite a los miembros de su equipo y al cliente que formarán parte del proyecto.'),
      placement: 'right',
			yOffset: -5,
			width: 240,
      //arrowOffset: 70
    },*/{
      target: 'more_proj_options_new',
      title: _('Definir las duraciones del proyecto'),
      content: _('Time-box su proyecto para rastrear la finalización oportuna.'),
      placement: 'right',
			yOffset: 20,
			width: 240,
      //arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};
var tour_invtuser_spa = {
  id: 'hello-hopscotch',
  i18n: {
	nextBtn: "Siguiente",
	prevBtn: "Espalda",
	doneBtn: "Hecho",
	skipBtn: "Omitir",
	//closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'txt_email',
      title: _('Añadir Usuarios'),
      content: _('Introduzca ID de correo electrónico para agregar usuarios. Utilice la coma como separador para invitar a varios usuarios a la vez.'),
      placement: 'bottom',
	  //yOffset: -5,
     // arrowOffset: 2
    },  
	{
      target: 'tour_impt_contact',
      title: _('Importar contactos'),
      content: _('Haga clic para agregar todos sus contactos de Google a Orangescrum.'),
      placement: 'bottom',
	  //yOffset: -3,
      //arrowOffset: 70
    },{
      target: 'tour_asnproj_user',
      title: _('Asignar proyectos'),
      content: _('Escriba Project Name para asignar el proyecto al usuario.'),
      placement: 'bottom',
	  //yOffset: -18,
	  //xOffset: 20,
      //arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};
var tour_invtuser_no_project_spa = {
  id: 'hello-hopscotch',
  i18n: {
  nextBtn: "Siguiente",
  prevBtn: "Espalda",
  doneBtn: "Hecho",
  skipBtn: "Omitir",
  //closeTooltip: "schließen",
  //stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'txt_email',
      title: _('Añadir Usuarios'),
      content: _('Introduzca ID de correo electrónico para agregar usuarios. Utilice la coma como separador para invitar a varios usuarios a la vez.'),
      placement: 'bottom',
    //yOffset: -5,
     // arrowOffset: 2
    },  
  {
      target: 'tour_impt_contact',
      title: _('Importar contactos'),
      content: _('Haga clic para agregar todos sus contactos de Google a Orangescrum.'),
      placement: 'bottom',
    //yOffset: -3,
      //arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};
var tour_user_spa = {
  id: 'hello-hopscotch',
   i18n: {
	nextBtn: "Siguiente",
	prevBtn: "Espalda",
	doneBtn: "Hecho",
	skipBtn: "Omitir",
	//closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
	{
      target: 'tour_invt_user_btn',
      title: _('Añadir / Invitar Nuevo Usuario'),
      content: _('Haga clic aquí para agregar / invitar a un nuevo usuario.'),
      placement: 'left',
	  yOffset: -5,
      arrowOffset: 2
    },
    {
      target: 'tour_actv_user',
      title: _('Usuario activo'),
      content: _('Todos los usuarios activos en tu cuenta de Orangescrum.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 5
    },  
	{
      target: 'tour_invt_user',
      title: _('Usuario invitado'),
      content: _('Todos los usuarios invitados que aún no se han registrado.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 5
    },{
      target: 'tour_clint_user',
      title: _('Usuario cliente'),
      content: _('Lista de todos los usuarios del cliente'),
      placement: 'right',
	  yOffset: -18,
	  xOffset: 10,
      //arrowOffset: 70
    },{
      target: 'tour_disbl_user',
      title: _('Deshabilitar usuario'),
      content: _('Todos los usuarios con discapacidad. Estos usuarios ya no pueden acceder a Orangescrum.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 5,
    },{
      target: 'tour_proj_srch',
      title: _('Buscar usuario'),
      content: _('Busca un usuario particular desde aquí.'),
      placement: 'right',
	  yOffset: -18,
	  xOffset: 20,
    },{
      target: 'tour_role_user',
      title: _('Rol del usuario'),
      content: _('Muestra el rol asignado (Propietario, Administrador, Usuario, Cliente) del usuario en la aplicación.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 2,
    },{
      target: 'tour_info_user',
      title: _('informacion del usuario'),
      content: _('La tarjeta de usuario muestra el Nombre de usuario, Rol, ID de correo electrónico, Fecha de la última actividad.'),
      placement: 'right',
	  yOffset: -25,
      //arrowOffset: 70
    },{
      target: 'tour_projs_user',
      title: _('Proyectos asignados'),
      content: _('Muestra los proyectos asignados.'),
      placement: 'right',
	  yOffset: -5,
      //arrowOffset: 70
    },{
      target: 'tour_acton_user',
      title: _('Otras acciones'),
      content: _('Asigne o elimine proyectos, otorgue o revoque el acceso de administrador o cliente o deshabilite al usuario aquí.'),
      placement: 'right',
	  yOffset: -20,
      //arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};

/*-----Spanish end here-----*/


/*-----french start here-----*/
var tour_fra = {
  id: 'hello-hopscotch',
  i18n: {
	nextBtn: "Suivant",
	prevBtn: "Retour",
	doneBtn: "Terminé",
	skipBtn: "Sauter",
	//closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'new_onboarding_add_icon',
      title: _('Créer une tâche'),
      content: _('Ajoutez des tâches à votre projet que vous venez de créer, puis affectez et commencez à collaborer ...'),
      placement: 'bottom',
	  yOffset: -18,
      arrowOffset: 7
    },
	{
      target: 'no-task-crt-task',
      title: _('Créer une nouvelle tâche'),
      content: _('Ajoutez des tâches à vos projets, assignez et collaborez ...'),
      placement: 'bottom',
      arrowOffset: 30
    },
	{
      target: 'new_task_label',
      placement: 'bottom',
      title: _('Tâche rapide'),
      content: _("Créer une tâche rapidement - entrez la date d'échéance, le type de tâche, l'affectation à et l'heure estimée"),
      yOffset: -4,
	  arrowOffset: 20
    },
    {
      target: 'no-task-impt-task',
      placement: 'bottom',
      title: _('Migrer ailleurs?'),
      content: _('Cliquez ici pour importer toutes vos tâches dans Orangescrum ...'),
      yOffset: -7
    },
    {
      target: 'left_menu_nav_tour',
      title: _('Navigation facile'),
      content: _('Naviguez rapidement entre Ma tâche, En retard et autres'),
      placement: 'right',
      //xOffset: -15,
	  //yOffset: -10
	  arrowOffset: 10
    },
    {
      target: 'task_filter',
      placement: 'left',
      title: _('Appliquer le filtre'),
      content: _('Filtrez en affinant votre recherche. Enregistrez votre filtre pour référence rapide'),
      yOffset: -15,
	  xOffset: 10,
	  arrowOffset: 1
    },
    {
      target: 'ajaxCaseStatus',
      placement: 'bottom',
      title: _('Filtre rapide: Statut de la tâche'),
      content: _('Différence des tâches en fonction de leur statut'),
      //yOffset: -17
	  arrowOffset: 24
    },
    {
      target: 'topactions',
      placement: 'bottom',
      title: _('Accès à différentes vues de tâches?'),
      content: _('Accéder à la vue des tâches préférée - Vue Liste des tâches / Groupe de tâches / Kanban ou Calendrier'),
      xOffset: 54,
	  yOffset: 5,
      arrowOffset: 75,
    },
    {
      target: 'task_impExp',
      placement: 'left',
      title: _("Tâches d'exportation"),
      content: _('Exporter des tâches au format CSV / PDF'),
	  yOffset: -15,
	  xOffset: 5,
	  arrowOffset: 1
    },    
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};


var tour_crttask_fra = {
  id: 'hello-hopscotch',
  i18n: {
	nextBtn: "Suivant",
	prevBtn: "Retour",
	doneBtn: "Terminé",
	skipBtn: "Sauter",
	//closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'CS_title',
      title: _('Titre de la tâche'),
      content: _('Nommez la tâche à créer'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },
	/*{
      target: 'CS_parent_task',
      title: _('Parent Task'),
      content: _('Select a parent task to create subtask.'),
      placement: 'bottom',
	  yOffset: 25,
      arrowOffset: 70
    },*/	
	{
      target: 'tour_crt_asign',
      title: _('Affecter à'),
      content: _("Sélectionnez l'utilisateur pour y travailler"),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_type',
      title: _('Type de tâche'),
      content: _('Classer la tâche pour mieux comprendre ou sélectionner un type de tâche prédéfini (par exemple, Développement, Bug)'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_prio',
      title: _('Définir la priorité'),
      content: _('Définir la priorité ici'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_desc',
      title: _('Description de la tâche'),
      content: _('Un peu de description de la tâche. Pour les tâches répétitives, sélectionnez simplement le modèle'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_attach',
      title: _('Joindre des fichiers'),
      content: _('Glissez et déposez vos fichiers sur cette zone. Les fichiers de Dropbox / Google Drive peuvent également être joints'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_srtend',
      title: _('Date de début et de fin'),
      content: _('Prenez votre temps pour le suivre'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_tskgrp',
      title: _('Groupe de travail'),
      content: _('Permet de regrouper des tâches similaires'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_estmtd',
      title: _('Heures estimées'),
      content: _("Définir l'heure prévue pour l'achèvement de la tâche"),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },
	{
      target: 'tour_crt_timrng',
      title: _('Intervalle de temps'),
      content: _('Définir un intervalle de temps spécifique pour la tâche, y compris la pause; Les heures passées seront automatiquement calculées'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },
	{
      target: 'tour_crt_recur',
      title: _('Récurrent'),
      content: _('Répéter la tâche par fréquence - Quotidien, Hebdomadaire, Mensuel ou Annuel'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_isbil',
      title: _('Est-ce facturable?'),
      content: _('Marquer la tâche si le coût est associé'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },
	{
      target: 'tour_crt_relate',
      title: _('Relation de tâche'),
      content: _("Cela aide à faire référence à une tâche à une autre. Tel que<br /><br /><b>Se rapporte à</b>: Cela montre que la tâche prévue est liée à ce qui suit \'Tâche de liaison\'.<br /><b>Dupliqué par</b>: Ceci montre que la tâche prévue est une tâche dupliquée d’une tâche existante.<br /><b>Dérivé de</b>: Cela montre que la tâche prévue est dérivée ou est le résultat d’une tâche existante."),
      placement: 'bottom',
	  yOffset: -4,
      arrowOffset: 70
    },
	{
      target: 'tour_crt_linking',
      title: _('Liaison de tâches'),
      content: _('Ajouter la tâche que vous souhaitez lier à'),
      placement: 'bottom',
	  yOffset: -4,
      arrowOffset: 70
    },	
	{
      target: 'tour_crt_label',
      title: _('Etiquette de tâche'),
      content: _('Marquer une tâche avec une ou plusieurs étiquettes'),
      placement: 'bottom',
	  yOffset: -4,
      arrowOffset: 70
    },
	{
      target: 'tour_crt_notify',
      title: _('Notifier les autres utilisateurs'),
      content: _("Envoyer des notifications sur la tâche à tous les membres de l'équipe."),
      placement: 'right',
	  //yOffset: -15,
      //arrowOffset: 70
    },
	/*{
      target: 'tour_crt_client',
      title: 'Private Task?',
      content: 'Check here to hide task from your clients.',
      placement: 'bottom',
	  yOffset: -15,
      arrowOffset: 70
    },*/
	{
      target: 'tour_crt_post',
      title: _('Créer une tâche'),
      content: _("Vous êtes prêt à partir! Cliquez sur Enregistrer et continuer pour créer une autre tâche."),
      placement: 'top',
	  //yOffset: -4,
      //arrowOffset: 150
    },	
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};

var tour_project_fra = {
  id: 'hello-hopscotch',
  i18n: {
	nextBtn: "Suivant",
	prevBtn: "Retour",
	doneBtn: "Terminé",
	skipBtn: "Sauter",
	//closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'tour_crt_proj_btn',
      title: _('Créer un projet'),
      content: _('Cliquez ici pour créer un nouveau projet.'),
      placement: 'left',
	  yOffset: -5,
      arrowOffset: 2
    },  
	{
      target: 'tour_crt_proj_swtch',
      title: _('Filtre rapide'),
      content: _('Naviguer dans les projets à travers différents statuts.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 70
    },{
      target: 'tour_proj_srch',
      title: _('Projet de recherche'),
      content: _('Recherche rapide de projets.'),
      placement: 'right',
	  yOffset: -18,
	  xOffset: 20,
      //arrowOffset: 70
    },{
      target: 'tour_proj_view',
      title: _('Vue du projet'),
      content: _("Définissez l'apparence de votre projet; 'Vue Carte' ou 'Vue Liste'."),
      placement: 'left',
	  //yOffset: -5,
     // arrowOffset: 70
    },{
      target: 'tour_proj_sts',
      title: _("L'état du projet"),
      content: _('Affiche le statut actuel du projet.'),
      placement: 'top',
	  xOffset: -15,
      //arrowOffset: 100
    },{
      target: 'tour_proj_shortnm',
      title: _('Nom abrégé du projet'),
      content: _('Votre nom abrégé de projet créé pendant le projet.'),
      placement: 'bottom',
	  yOffset: -9,
      //arrowOffset: 70
    },{
      target: 'tour_proj_crtdon',
      title: _('Créé sur'),
      content: _('La date à laquelle vous avez créé le projet.'),
      placement: 'right',
	  yOffset: -18,
      //arrowOffset: 70
    },{
      target: 'tour_proj_prio',
      title: _('Priorité du projet'),
      content: _('Affiche la priorité du projet.'),
      placement: 'right',
	  yOffset: -35,
      //arrowOffset: 70
    },{
      target: 'tour_proj_actn',
      title: _("D'autres actions"),
      content: _('Effectuez des actions telles que Ajouter ou supprimer un utilisateur, Modifier le projet, marquer le projet comme étant terminé.'),
      placement: 'right',
	  yOffset: -15,
      //arrowOffset: 70
    },
	{
      target: 'tour_proj_invlv',
      title: _('Equipe impliquée'),
      content: _('Affiche toutes les parties prenantes impliquées dans le projet.'),
      placement: 'right',
	  yOffset: -10,
      //arrowOffset: 70
    },
	{
      target: 'tour_proj_infos',
      title: _('Informations clés du projet'),
      content: _("Affiche le total des tâches, le temps passé et l'espace de stockage - sur ce projet."),
      placement: 'right',
	  yOffset: -5,
      //arrowOffset: 40
    },
	{
      target: 'tour_proj_renhr',
      title: _('Heures restantes'),
      content: _('Sachez combien d’heures il reste pour le lancement de votre projet.'),
      placement: 'bottom',
	  yOffset: -5,
      arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};


var tour_crtproj_fra = {
  id: 'hello-hopscotch',
  i18n: {
	nextBtn: "Suivant",
	prevBtn: "Retour",
	doneBtn: "Terminé",
	skipBtn: "Sauter",
	//closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'txt_Proj',
      title: _('nom du projet'),
      content: _('Donnez un nom significatif à votre projet.'),
      placement: 'bottom',
			delay: 1000,
	  //yOffset: -5,
     // arrowOffset: 2
    },  
	{
      target: 'txt_shortProj',
      title: _('Nom abrégé du projet'),
      content: _('Définissez un nom court unique pour le projet comme référence. Entrée alphanumérique de 5 caractères maximum.'),
      placement: 'bottom',
	  //yOffset: -3,
      //arrowOffset: 70
    },{
      target: 'priority_dropdown',
      title: _('Priorité'),
      content: _('Définissez la priorité appropriée - faible, moyenne ou élevée pour votre projet.'),
      placement: 'bottom',
	  //yOffset: -18,
	  //xOffset: 20,
      //arrowOffset: 70
    },{
      target: 'task_type',
      title: _('Type de tâche par défaut'),
      content: _('Définissez le type de tâche par défaut pour chaque tâche, par exemple, développement ou bogue'),
      placement: 'bottom',
	  //yOffset: -5,
     // arrowOffset: 70
    },{
      target: 'tmpl_dropdown',
      title: _('Ajouter un modèle de projet'),
      content: _('Sélectionnez un modèle de projet prédéfini ou, créez un nouveau'),
      placement: 'bottom',
	  //yOffset: -11,
      //arrowOffset: 100
    },{
      target: 'prj_desc',
      title: _('Ajouter des descriptions'),
      content: _('Ecrire un bref sur le projet est tout au sujet.'),
      placement: 'bottom',
	  yOffset: -9,
      //arrowOffset: 70
	},/*{
      target: 'members_list',
      title: _('Inviter des utilisateurs'),
      content: _('Invitez les membres de votre équipe et le client qui feront partie du projet.'),
      placement: 'right',
			yOffset: -5,
			width: 240,
      //arrowOffset: 70
    },*/{
      target: 'more_proj_options_new',
      title: _('Définir les durées du projet'),
      content: _('Placez votre projet dans le temps pour suivre son achèvement.'),
      placement: 'right',
			yOffset: 20,
			width: 240,
      //arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};
var tour_invtuser_fra = {
  id: 'hello-hopscotch',
  i18n: {
	nextBtn: "Suivant",
	prevBtn: "Retour",
	doneBtn: "Terminé",
	skipBtn: "Sauter",
	//closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'txt_email',
      title: _('Ajouter des utilisateurs'),
      content: _('Entrez les identifiants de messagerie pour ajouter des utilisateurs. Utilisez une virgule comme séparateur pour inviter plusieurs utilisateurs à la fois.'),
      placement: 'bottom',
	  //yOffset: -5,
     // arrowOffset: 2
    },  
	{
      target: 'tour_impt_contact',
      title: _("Contacts d'importation"),
      content: _('Cliquez pour ajouter tous vos contacts Google à Orangescrum.'),
      placement: 'bottom',
	  //yOffset: -3,
      //arrowOffset: 70
    },{
      target: 'tour_asnproj_user',
      title: _('Attribuer des projets'),
      content: _("Tapez Nom du projet pour affecter le projet à l'utilisateur."),
      placement: 'bottom',
	  //yOffset: -18,
	  //xOffset: 20,
      //arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};
var tour_invtuser_no_project_fra = {
  id: 'hello-hopscotch',
  i18n: {
  nextBtn: "Suivant",
  prevBtn: "Retour",
  doneBtn: "Terminé",
  skipBtn: "Sauter",
  //closeTooltip: "schließen",
  //stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'txt_email',
      title: _('Ajouter des utilisateurs'),
      content: _('Entrez les identifiants de messagerie pour ajouter des utilisateurs. Utilisez une virgule comme séparateur pour inviter plusieurs utilisateurs à la fois.'),
      placement: 'bottom',
    //yOffset: -5,
     // arrowOffset: 2
    },  
  {
      target: 'tour_impt_contact',
      title: _("Contacts d'importation"),
      content: _('Cliquez pour ajouter tous vos contacts Google à Orangescrum.'),
      placement: 'bottom',
    //yOffset: -3,
      //arrowOffset: 70
    },{
      target: 'tour_asnproj_user',
      title: _('Attribuer des projets'),
      content: _("Tapez Nom du projet pour affecter le projet à l'utilisateur."),
      placement: 'bottom',
    //yOffset: -18,
    //xOffset: 20,
      //arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};
var tour_user_fra = {
  id: 'hello-hopscotch',
  i18n: {
	nextBtn: "Suivant",
	prevBtn: "Retour",
	doneBtn: "Terminé",
	skipBtn: "Sauter",
	//closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
	{
      target: 'tour_invt_user_btn',
      title: _('Ajouter / Inviter un nouvel utilisateur'),
      content: _('Cliquez ici pour ajouter / inviter un nouvel utilisateur.'),
      placement: 'left',
	  yOffset: -5,
      arrowOffset: 2
    },
    {
      target: 'tour_actv_user',
      title: _('Utilisateur actif'),
      content: _('Tous les utilisateurs actifs de votre compte Orangescrum.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 5
    },  
	{
      target: 'tour_invt_user',
      title: _('Utilisateur invité'),
      content: _('Tous les utilisateurs invités qui ne se sont pas encore inscrits.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 5
    },{
      target: 'tour_clint_user',
      title: _('Utilisateur client'),
      content: _('Liste de tous les utilisateurs clients'),
      placement: 'right',
	  yOffset: -18,
	  xOffset: 10,
      //arrowOffset: 70
    },{
      target: 'tour_disbl_user',
      title: _("Désactiver l'utilisateur"),
      content: _('Tous les utilisateurs handicapés. Ces utilisateurs ne peuvent plus accéder à Orangescrum.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 5,
    },{
      target: 'tour_proj_srch',
      title: _('Rechercher un utilisateur'),
      content: _("Rechercher un utilisateur particulier à partir d'ici."),
      placement: 'right',
	  yOffset: -18,
	  xOffset: 20,
    },{
      target: 'tour_role_user',
      title: _("Rôle d'utilisateur"),
      content: _("Affiche le rôle attribué (propriétaire, administrateur, utilisateur, client) de l'utilisateur dans l'application."),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 2,
    },{
      target: 'tour_info_user',
      title: _("informations de l'utilisateur"),
      content: _("La carte d'utilisateur indique le nom d'utilisateur, le rôle, l'identifiant de messagerie et la date de la dernière activité."),
      placement: 'right',
	  yOffset: -25,
      //arrowOffset: 70
    },{
      target: 'tour_projs_user',
      title: _('Projects Assigned'),
      content: _('Affiche les projets assignés.'),
      placement: 'right',
	  yOffset: -5,
      //arrowOffset: 70
    },{
      target: 'tour_acton_user',
      title: _("D'autres actions"),
      content: _("Attribuez ou supprimez des projets, accordez ou révoquez l'accès administrateur ou client ou désactivez l'utilisateur ici."),
      placement: 'right',
	  yOffset: -20,
      //arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};
/*-----french end here-----*/

/*-----Portugees start here-----*/
var tour_por = {
  id: 'hello-hopscotch',
  i18n: {
	nextBtn: "Próxima",
	prevBtn: "De volta",
	doneBtn: "Feito",
	skipBtn: "Feito",
	//closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'new_onboarding_add_icon',
      title: _('Criar tarefa'),
      content: _('Adicione Tarefas ao seu projeto recém-criado, atribua e comece a colaborar ...'),
      placement: 'bottom',
	  yOffset: -18,
      arrowOffset: 7
    },
	{
      target: 'no-task-crt-task',
      title: _('Criar nova tarefa'),
      content: _('Adicione tarefas aos seus projetos, atribua e colabore ...'),
      placement: 'bottom',
      arrowOffset: 30
    },
	{
      target: 'new_task_label',
      placement: 'bottom',
      title: _('Tarefa Rápida'),
      content: _('Criar tarefa rapidamente - insira Data de vencimento, Tipo de tarefa, Atribuir a e hora estimada'),
      yOffset: -4,
	  arrowOffset: 20
    },
    {
      target: 'no-task-impt-task',
      placement: 'bottom',
      title: _('Migrando de algum outro lugar?'),
      content: _('Clique aqui para importar todas as suas tarefas para o Orangescrum ...'),
      yOffset: -7
    },
    {
      target: 'left_menu_nav_tour',
      title: _('Navegação Fácil'),
      content: _('Navegue rapidamente entre minha tarefa, atrasada e outros'),
      placement: 'right',
      //xOffset: -15,
	  //yOffset: -10
	  arrowOffset: 10
    },
    {
      target: 'task_filter',
      placement: 'left',
      title: _('Aplicar filtro'),
      content: _('Filtrar estreitando sua pesquisa. Salve seu filtro para referência rápida'),
      yOffset: -15,
	  xOffset: 10,
	  arrowOffset: 1
    },
    {
      target: 'ajaxCaseStatus',
      placement: 'bottom',
      title: _('Filtro Rápido: Status da Tarefa'),
      content: _('Diferença de tarefas com base em seu status'),
      //yOffset: -17
	  arrowOffset: 24
    },
    {
      target: 'topactions',
      placement: 'bottom',
      title: _('Acesso a diferentes tarefas?'),
      content: _('Acessar a visualização de tarefas preferida - Lista de Tarefas / Grupo de Tarefas / Kanban ou Visualização de Calendário'),
      xOffset: 54,
	  yOffset: 5,
      arrowOffset: 75,
    },
    {
      target: 'task_impExp',
      placement: 'left',
      title: _('Exportar tarefas'),
      content: _('Exportar tarefas em CSV / PDF'),
	  yOffset: -15,
	  xOffset: 5,
	  arrowOffset: 1
    },    
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};


var tour_crttask_por = {
  id: 'hello-hopscotch',
  i18n: {
	nextBtn: "Próxima",
	prevBtn: "De volta",
	doneBtn: "Feito",
	skipBtn: "Feito",
	//closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'CS_title',
      title: _('Título da Tarefa'),
      content: _('Nomeie a tarefa para criar'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },
	/*{
      target: 'CS_parent_task',
      title: _('Parent Task'),
      content: _('Select a parent task to create subtask.'),
      placement: 'bottom',
	  yOffset: 25,
      arrowOffset: 70
    },*/	
	{
      target: 'tour_crt_asign',
      title: _('Atribuir a'),
      content: _("Selecione o usuário para trabalhar nele"),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_type',
      title: _('Tipo de Tarefa'),
      content: _('Classifique melhor a tarefa para entender ou selecione um tipo de tarefa predefinido (por exemplo, Desenvolvimento, Bug)'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_prio',
      title: _('Definir prioridade'),
      content: _('Defina a prioridade aqui'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_desc',
      title: _('Descrição da tarefa'),
      content: _('Um pouco de descrição sobre a tarefa. Para tarefas repetitivas, basta selecionar o modelo'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_attach',
      title: _('Anexar arquivos'),
      content: _('Arraste e solte seus arquivos nesta área. Arquivos do Dropbox / Google drive também podem ser anexados'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_srtend',
      title: _('Data de início e término'),
      content: _('Time-box sua tarefa para acompanhar isso'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_tskgrp',
      title: _('Grupo de Tarefas'),
      content: _('Permite agrupar tarefas semelhantes'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_estmtd',
      title: _('Horas estimadas'),
      content: _('Definir o tempo planejado para conclusão da tarefa'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },
	{
      target: 'tour_crt_timrng',
      title: _('Intervalo de tempo'),
      content: _('Defina um intervalo de tempo específico para a tarefa, incluindo o intervalo; As horas dedicadas serão calculadas automaticamente'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },
	{
      target: 'tour_crt_recur',
      title: _('Recorrente'),
      content: _('Repetir tarefa por frequência - diária, semanal, mensal ou anual'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },{
      target: 'tour_crt_isbil',
      title: _('É faturável?'),
      content: _('Marcar a tarefa se o custo associado'),
      placement: 'bottom',
	  yOffset: -9,
      arrowOffset: 70
    },
	{
      target: 'tour_crt_relate',
      title: _('Tarefa Relacionar'),
      content: _("Isso ajuda a se referir a uma tarefa para outra. Tal como<br /><br /><b>Refere-se à</b>: Isso mostra que a tarefa pretendida está relacionada ao seguinte \'Tarefa de Vinculação\'.<br /><b>Duplicado por</b>: Mostra que a tarefa pretendida é derivada ou um resultado de uma tarefa existente.<br /><b>Derivado de</b>: Mostra que a tarefa pretendida é derivada ou um resultado de uma tarefa existente."),
      placement: 'bottom',
	  yOffset: -4,
      arrowOffset: 70
    },
	{
      target: 'tour_crt_linking',
      title: _('Ligação de Tarefas'),
      content: _('Adicione a tarefa que você gostaria de vincular'),
      placement: 'bottom',
	  yOffset: -4,
      arrowOffset: 70
    },	
	{
      target: 'tour_crt_label',
      title: _('Rótulo da Tarefa'),
      content: _('Marcar uma tarefa com rótulo (s)'),
      placement: 'bottom',
	  yOffset: -4,
      arrowOffset: 70
    },
	{
      target: 'tour_crt_notify',
      title: _('Notificar outros usuários'),
      content: _('Envie notificações sobre a tarefa para todos os membros da equipe.'),
      placement: 'right',
	  //yOffset: -15,
      //arrowOffset: 70
    },
	/*{
      target: 'tour_crt_client',
      title: 'Private Task?',
      content: 'Check here to hide task from your clients.',
      placement: 'bottom',
	  yOffset: -15,
      arrowOffset: 70
    },*/
	{
      target: 'tour_crt_post',
      title: _('Criar tarefa'),
      content: _("Você é bom para ir! Clique em Salvar e continuar para criar outra tarefa."),
      placement: 'top',
	  //yOffset: -4,
      //arrowOffset: 150
    },	
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};

var tour_project_por = {
  id: 'hello-hopscotch',
  i18n: {
	nextBtn: "Próxima",
	prevBtn: "De volta",
	doneBtn: "Feito",
	skipBtn: "Feito",
	//closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'tour_crt_proj_btn',
      title: _('Criar projeto'),
      content: _('Clique aqui para criar um novo projeto.'),
      placement: 'left',
	  yOffset: -5,
      arrowOffset: 2
    },  
	{
      target: 'tour_crt_proj_swtch',
      title: _('Filtro Rápido'),
      content: _('Navegue por projetos em vários status.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 70
    },{
      target: 'tour_proj_srch',
      title: _('Projeto de pesquisa'),
      content: _('Pesquisa rápida de projetos.'),
      placement: 'right',
	  yOffset: -18,
	  xOffset: 20,
      //arrowOffset: 70
    },{
      target: 'tour_proj_view',
      title: _('Visão do Projeto'),
      content: _("Defina como o seu projeto deve ser; 'Card View' ou 'List View'."),
      placement: 'left',
	  //yOffset: -5,
     // arrowOffset: 70
    },{
      target: 'tour_proj_sts',
      title: _('Status do projeto'),
      content: _('Exibe o status atual do projeto.'),
      placement: 'top',
	  xOffset: -15,
      //arrowOffset: 100
    },{
      target: 'tour_proj_shortnm',
      title: _('Nome abreviado do projeto'),
      content: _('Nome curto do seu projeto criado durante o projeto.'),
      placement: 'bottom',
	  yOffset: -9,
      //arrowOffset: 70
    },{
      target: 'tour_proj_crtdon',
      title: _('Criado em'),
      content: _('A data em que você criou o projeto.'),
      placement: 'right',
	  yOffset: -18,
      //arrowOffset: 70
    },{
      target: 'tour_proj_prio',
      title: _('Prioridade do Projeto'),
      content: _('Mostra a prioridade do projeto.'),
      placement: 'right',
	  yOffset: -35,
      //arrowOffset: 70
    },{
      target: 'tour_proj_actn',
      title: _('Outras ações'),
      content: _('Execute ações como Adicionar ou Remover Usuário, Editar Projeto, marcar projeto como Completo.'),
      placement: 'right',
	  yOffset: -15,
      //arrowOffset: 70
    },
	{
      target: 'tour_proj_invlv',
      title: _('Equipe envolvida'),
      content: _('Mostra todas as partes interessadas envolvidas no projeto.'),
      placement: 'right',
	  yOffset: -10,
      //arrowOffset: 70
    },
	{
      target: 'tour_proj_infos',
      title: _('Informações Chave do Projeto'),
      content: _('Mostra o total de tarefas, tempo gasto e espaço de armazenamento - neste projeto.'),
      placement: 'right',
	  yOffset: -5,
      //arrowOffset: 40
    },
	{
      target: 'tour_proj_renhr',
      title: _('Horas restantes'),
      content: _('Saiba quantas horas restam para o lançamento do seu projeto.'),
      placement: 'bottom',
	  yOffset: -5,
      arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};


var tour_crtproj_por = {
  id: 'hello-hopscotch',
  i18n: {
	nextBtn: "Próxima",
	prevBtn: "De volta",
	doneBtn: "Feito",
	skipBtn: "Feito",
	//closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'txt_Proj',
      title: _('Nome do Projeto'),
      content: _('Forneça um nome significativo para seu projeto.'),
      placement: 'bottom',
			delay: 1000,
	  //yOffset: -5,
     // arrowOffset: 2
    },  
	{
      target: 'txt_shortProj',
      title: _('Nome abreviado do projeto'),
      content: _('Defina um nome abreviado exclusivo para projeto para referência. Entrada alfanumérica com no máximo 5 caracteres.'),
      placement: 'bottom',
	  //yOffset: -3,
      //arrowOffset: 70
    },{
      target: 'priority_dropdown',
      title: _('Prioridade'),
      content: _('Defina Prioridade apropriada - Baixa, Média ou Alta para o seu projeto.'),
      placement: 'bottom',
	  //yOffset: -18,
	  //xOffset: 20,
      //arrowOffset: 70
    },{
      target: 'task_type',
      title: _('Tipo de Tarefa Padrão'),
      content: _('Defina o tipo de tarefa padrão para cada tarefa, por exemplo, Desenvolvimento ou Bug'),
      placement: 'bottom',
	  //yOffset: -5,
     // arrowOffset: 70
    },{
      target: 'tmpl_dropdown',
      title: _('Adicionar modelo de projeto'),
      content: _('Selecione um modelo de projeto predefinido ou crie um novo'),
      placement: 'bottom',
	  //yOffset: -11,
      //arrowOffset: 100
    },{
      target: 'prj_desc',
      title: _('Adicionar descrições'),
      content: _('Escreva uma breve sobre o projeto é tudo.'),
      placement: 'bottom',
	  yOffset: -9,
      //arrowOffset: 70
	},/*{
      target: 'members_list',
      title: _('Convidar usuários'),
      content: _('Convide os membros da sua equipe e o cliente que fará parte do projeto.'),
      placement: 'right',
			yOffset: -5,
			width: 240,
      //arrowOffset: 70
    },*/{
      target: 'more_proj_options_new',
      title: _('Definir as durações do projeto'),
      content: _('Time-box seu projeto para acompanhar a conclusão oportuna.'),
      placement: 'right',
			yOffset: 20,
			width: 240,
      //arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};
var tour_invtuser_por = {
  id: 'hello-hopscotch',
  i18n: {
	nextBtn: "Próxima",
	prevBtn: "De volta",
	doneBtn: "Feito",
	skipBtn: "Feito",
	//closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'txt_email',
      title: _('Adicionar usuários'),
      content: _('Insira os IDs de e-mail para adicionar usuários. Use vírgula como separador para convidar vários usuários por vez.'),
      placement: 'bottom',
	  //yOffset: -5,
     // arrowOffset: 2
    },  
	{
      target: 'tour_impt_contact',
      title: _('Contatos importantes'),
      content: _('Clique para adicionar todos os seus contatos do Google ao Orangescrum.'),
      placement: 'bottom',
	  //yOffset: -3,
      //arrowOffset: 70
    },{
      target: 'tour_asnproj_user',
      title: _('Atribuir Projetos'),
      content: _('Digite Nome do Projeto para atribuir um projeto ao usuário.'),
      placement: 'bottom',
	  //yOffset: -18,
	  //xOffset: 20,
      //arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};
var tour_invtuser_no_project_por = {
  id: 'hello-hopscotch',
  i18n: {
  nextBtn: "Próxima",
  prevBtn: "De volta",
  doneBtn: "Feito",
  skipBtn: "Feito",
  //closeTooltip: "schließen",
  //stepNums : ["1", "2", "3"]
  },
  steps: [
    {
      target: 'txt_email',
      title: _('Adicionar usuários'),
      content: _('Insira os IDs de e-mail para adicionar usuários. Use vírgula como separador para convidar vários usuários por vez.'),
      placement: 'bottom',
    //yOffset: -5,
     // arrowOffset: 2
    },  
  {
      target: 'tour_impt_contact',
      title: _('Contatos importantes'),
      content: _('Clique para adicionar todos os seus contatos do Google ao Orangescrum.'),
      placement: 'bottom',
    //yOffset: -3,
      //arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};
var tour_user_por = {
  id: 'hello-hopscotch',
  i18n: {
	nextBtn: "Próxima",
	prevBtn: "De volta",
	doneBtn: "Feito",
	skipBtn: "Feito",
	//closeTooltip: "schließen",
	//stepNums : ["1", "2", "3"]
  },
  steps: [
	{
      target: 'tour_invt_user_btn',
      title: _('Adicionar / convidar novo usuário'),
      content: _('Clique aqui para adicionar / convidar novo usuário.'),
      placement: 'left',
	  yOffset: -5,
      arrowOffset: 2
    },
    {
      target: 'tour_actv_user',
      title: _('Usuário ativo'),
      content: _('Todos os usuários ativos em sua conta Orangescrum.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 5
    },  
	{
      target: 'tour_invt_user',
      title: _('Usuário Convidado'),
      content: _('Todos os usuários convidados que ainda não se inscreveram.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 5
    },{
      target: 'tour_clint_user',
      title: _('Usuário cliente'),
      content: _('Lista de todos os usuários clientes'),
      placement: 'right',
	  yOffset: -18,
	  xOffset: 10,
      //arrowOffset: 70
    },{
      target: 'tour_disbl_user',
      title: _('Desativar usuário'),
      content: _('Todos os usuários com deficiência. Esses usuários não podem mais acessar o Orangescrum.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 5,
    },{
      target: 'tour_proj_srch',
      title: _('Pesquisar usuário'),
      content: _('Pesquise um usuário específico daqui.'),
      placement: 'right',
	  yOffset: -18,
	  xOffset: 20,
    },{
      target: 'tour_role_user',
      title: _('Papel do usuário'),
      content: _('Mostra a função atribuída (Proprietário, Administrador, Usuário, Cliente) do usuário no aplicativo.'),
      placement: 'bottom',
	  yOffset: -3,
      arrowOffset: 2,
    },{
      target: 'tour_info_user',
      title: _('Informação do usuário'),
      content: _('O cartão de usuário mostra o nome do usuário, função, ID de e-mail, data da última atividade.'),
      placement: 'right',
	  yOffset: -25,
      //arrowOffset: 70
    },{
      target: 'tour_projs_user',
      title: _('Projetos Atribuídos'),
      content: _('Mostra os projetos atribuídos.'),
      placement: 'right',
	  yOffset: -5,
      //arrowOffset: 70
    },{
      target: 'tour_acton_user',
      title: _('Outras ações'),
      content: _('Atribua ou remova projetos, conceda ou revogue o acesso de administrador ou cliente ou desative o usuário aqui.'),
      placement: 'right',
	  yOffset: -20,
      //arrowOffset: 70
    },
  ],
  showPrevButton: true,
  scrollTopMargin: 100,onStart: function(){$('body').addClass('hopscotch_bubble_body');},onEnd: function() {removeOnboard();},onClose: function() {removeOnboard();}
};

//new onboarding starts
var onbd_tour_project = {
  id: 'hello-hopscotch',
  /*i18n: {
	nextBtn: "Próxima",
	prevBtn: "De volta",
	doneBtn: "Feito",
	skipBtn: "Feito",
  },*/
  steps: [
		{
			target: 'new_onboarding_add_icon',
			title: _('Get Started To Create Project'),
			content: _('Convert business ideas into Projects and deliver on-time.'),
			placement: 'right',
			yOffset: 20,
			arrowOffset: 2,
			onNext: function() {
				newProject();
			}
		},
		{
			target: 'txt_Proj',
			title: _('Project Name'),
			content: _('Provide a meaningful name for your Project.'),
			placement: 'left',//bottom
			//yOffset: -5,
			width: 220,
		 // arrowOffset: 2
		 delay: 1000
		},  
		{
      target: 'txt_shortProj',
      title: _('Project Short Name'),
      content: _('Define a unique short name for project for reference. Alphanumeric entry with max 5 characters.'),
      placement: 'bottom',
	  //yOffset: -3,
      //arrowOffset: 70
    },
		{
      target: 'priority_dropdown',
      title: _('Priority'),
      content: _('Set the right Priority - Low, Medium or High for your project.'),
      placement: 'right', //left
			width: 220,
			//yOffset: -18,
			//xOffset: 20,
      //arrowOffset: 70
    },
		{
      target: 'task_type',
      title: _('Default Task Type'),
      content: _('Set the default task type for each task, e.g., Development or Bug.'),
      placement: 'top',
			yOffset: -9,
     // arrowOffset: 70
    },
		{
      target: 'tmpl_dropdown',
      title: _('Add Project Plan'),
      content: _('Select a pre-defined Project Plan or, Create a new one.'),
      placement: 'top',
			yOffset: -9,
      //arrowOffset: 100
    },
		{
      target: 'prj_desc',
      title: _('Add Descriptions'),
      content: _('Give an overview of what the project will accomplish.'),
      placement: 'left',//bottom
			yOffset: -5,
			width: 220,
      //arrowOffset: 70
    },
		/*{
      target: 'members_list',
      title: _('Invite Users'),
      content: _('Invite your team members and customer who will be part of the project.'),
      placement: 'left',//top
			yOffset: 5,
      //arrowOffset: 70			
			onNext: function() {
				//$('#more_proj_options').trigger('click');
			}
    },*/
		{
      target: 'more_proj_options_new',
      title: _('Define Project Duration'),
      content: _('Time-box your project to track execution.'),
      placement: 'right', //top
			yOffset: 20,
			width: 280,
      //arrowOffset: 70,
			//delay: 500,
      multipage : true,
			onNext: function() {
				window.location = HTTP_ROOT + 'templates/projects';
			}
    },
		{
      target: 'onbdproject_temp_tour',
      title: _('Build Your Project Plan'),
      content: _('Create predefined plans for specific projects, reuse them forever and save time.'),
      placement: 'left',
			yOffset: -5,
      multipage : true,
			delay: 500,
			onNext: function() {
				//manageTemplate('600'); NEED TO BE DONE
				$.post(HTTP_ROOT + "projects/ajax_get_ptemp", {
				}, function(data) {
					window.location = HTTP_ROOT + 'templates/projects/'+btoa(data.uid);
				},'json');
			}
    },
		{
      target: 'new_grp_label',
      title: _('My Project Template!'),
      content: _('Create taskgroups, tasks & subtasks, assignee & define estimated hours. Tag the template to a project and get set for execution.'),
      placement: 'bottom',
			yOffset: 10,
      //multipage : true,
			//delay: 5000,
			onNext: function() {
				//manageTemplate('600');				
				$('#tour_profile_setting').parent('li').addClass('profl_nav_active_section');				
				//console.log($('#tour_profile_setting').parent('li'));
				setTimeout(function() {
					$(".hover-menu").addClass('profl_nav_active_section');
					$('document').find('.top_maindropdown-menu').addClass("fadein_bkp").removeClass("fadeout_bkp").show();
					$('#tour_profile_setting').parent('li').addClass('open');
					$('#tour_mainporf_setting_drop').show();
					$('#tour_project_settings').trigger('click');
				},100);
			}
    },
		{
      target: 'tour_task_type',
      title: _('Custom Task Type'), //Click
      content: _('Create unlimited custom tasks types for better task categorization.'),
      placement: 'left',
			yOffset: -5,
      multipage : true,
			delay: 1000,
			onNext: function() {
				window.location = HTTP_ROOT + 'task-type';
			}
    },
		{
      target: 'tour_new_task_type',
      title: _('Meaningful Task Classification'),
      content: _('Create unlimited task types to better classify the various activities of your projects. Smart filters from the task list page help you identify and execute them quickly.'),
      placement: 'left',
			yOffset: -5,
      //multipage : true,
			//delay: 1000,
			onNext: function() {
				$('#tour_profile_setting').parent('li').addClass('profl_nav_active_section');
				setTimeout(function() {
					$(".hover-menu").addClass('profl_nav_active_section');
					$('document').find('.top_maindropdown-menu').addClass("fadein_bkp").removeClass("fadeout_bkp").show();
					$('#tour_profile_setting').parent('li').addClass('open');
					$('#tour_mainporf_setting_drop').show();
					$('#tour_company_settings').trigger('click');
				},100);
			}
    },
		{
      target: 'tour_sts_work_flow_setting',
      title: _('Give Your Projects A Flow'),
      content: _('Give each project a unique yet logical task flow from start to finish!Status Workflow that is native to your projects and team.'),
      placement: 'left',
			yOffset: 5,
      multipage : true,
			delay: 100,
			onNext: function() {
				window.location = HTTP_ROOT + 'workflow-setting';
			}
    },
		{
      target: 'tour_workflow_setting',
      title: _('Unique Status Workflow For Your Projects'),
      content: _('Define a group of unique status for your tasks, assign a progress percentage & color schema for each status. Just update the status and see your task progress being updated at once. Build custom status workflow for each project or reuse across projects.'),
      placement: 'left',
			yOffset: -15,
      multipage : true,
			delay: 100,
			width: 350,
			onNext: function() {
				window.location = HTTP_ROOT + 'dashboard#/overview';
			}
    },
		{
      target: 'tour_overview_statistics',
      title: _('See Your Performance'),
      content: _('Track your team’s performance, project progress & prevent delays. Deliver on time, within budget and with confidence.'),
      placement: 'bottom',
			//yOffset: -5,
      //multipage : true,
			delay: 100,
			yOffset: -15,
			xOffset: 30,
      arrowOffset: 27,
			onNext: function() {
			}
    },
  ],
  showPrevButton: false,
  scrollTopMargin: 100,
  onStart: function(){
    localStorage.setItem("tour_frm_close",'0');
		$('body').addClass('hopscotch_bubble_body');
  },
	onEnd: function() {
		$('body').removeClass('hopscotch_bubble_body');
		var t_compl = 0;
		localStorage.setItem("tour_type", '0');
		if(localStorage.getItem("tour_frm_close") != '1'){
			if(localStorage.getItem("tour_complete")){
				t_compl = localStorage.getItem("tour_complete");
				if(t_compl.indexOf(1) == -1){
					localStorage.setItem("tour_complete",t_compl+',1');
				}
			}else{
				localStorage.setItem("tour_complete",'1');
			}
		}
		localStorage.setItem("tour_frm_close",'0');
		newOnboarding();
	},
	onClose: function() {
		$('body').removeClass('hopscotch_bubble_body');
		localStorage.setItem("tour_type", '0');
		localStorage.setItem("tour_frm_close", '1');
		if(localStorage.getItem("onboard_is_on") != '1'){
		newOnboarding();
	}
	}
}; 

//resource planning
var onbd_tour_resource = {
  id: 'hello-hopscotch',
  /*i18n: {
	nextBtn: "Próxima",
	prevBtn: "De volta",
	doneBtn: "Feito",
	skipBtn: "Feito",
  },*/
  steps: [
		{
			target: 'tour_user_role_mgt',
			title: _('Configure Custom Permissions'),
			content: _('Group your users by departments, create roles for them and custom configure their permissions within the tool.'),
			placement: 'left',
			yOffset: 1,
			arrowOffset: 2,
			multipage : true,
			delay: 1000,
			width: 350,
			onNext: function() {
				window.location = HTTP_ROOT + 'user-role-settings/';
			}
		},		
		{
      target: 'tour_new_role_group',
      title: _('Bring In Your Teams'),
      content: _('Create role groups for all the departments within your company for all inclusive collaboration.'),
      placement: 'left',
			yOffset: -5,
      //arrowOffset: 70,
      //multipage : true,
			delay: 1000,
			onNext: function() {
				newRole('add');
			}
    },
		{
      target: 'tour_add_new_role',
      title: _('Define Their Roles'),
      content: _('Maintain consistent organization roles to keep everyone involved together.'),
      placement: 'right',
			yOffset: 75,
      //multipage : true,
			delay: 2000,
			onNext: function() {
				closePopup();
				$('#tour_role_group').trigger('click');
				//setTimeout(function() {
					$('#tour_role_action_ul').show();
					//$('#tour_role_action_ul').css('display','block !important');
				//},1000);
			}
    },
		{
      target: 'tour_role_action',
      title: _('Configure Permissions And Actions'),
      content: _('Prevent distractions with tailor made permissions and share information on a \'need to know\' basis.'),
      placement: 'top',
			//xOffset: -15,
			yOffset: 25,
      //multipage : true,
			//delay: 2000,
			onNext: function() {
			}
    },		
  ],
	//onStart: ["tour_role_action"],
  showPrevButton: false,
  scrollTopMargin: 100,
  onStart: function(){
    localStorage.setItem("tour_frm_close",'0');
		$('body').addClass('hopscotch_bubble_body');
  },
	onEnd: function() {
		$('body').removeClass('hopscotch_bubble_body');
		var t_compl = 0;
		localStorage.setItem("tour_type", '0');
		if(localStorage.getItem("tour_frm_close") != '1'){
			if(localStorage.getItem("tour_complete")){
				t_compl = localStorage.getItem("tour_complete");
				if(t_compl.indexOf(2) == -1){
					localStorage.setItem("tour_complete",t_compl+',2');
				}
			}else{
				localStorage.setItem("tour_complete",'2');
			}
		}
		localStorage.setItem("tour_frm_close",'0');
		newOnboarding();
	},
	onClose: function() {
		$('body').removeClass('hopscotch_bubble_body');
		localStorage.setItem("tour_type", '0');
		localStorage.setItem("tour_frm_close",'1');
		if(localStorage.getItem("onboard_is_on") != '1'){
		newOnboarding();
	}
	}
};

//Manage your work
var onbd_tour_mngwork = {
  id: 'hello-hopscotch',
  /*i18n: {
	nextBtn: "Próxima",
	prevBtn: "De volta",
	doneBtn: "Feito",
	skipBtn: "Feito",
  },*/
  steps: [
		{
			target: 'tour_task_title_listing',
			title: _('The Stage Is Set!'),
			content: _('Create tasks, assign them and begin project execution.'),
			placement: 'bottom',
			yOffset: -20,
			arrowOffset: 2,
			//multipage : true,
			delay: 1000,
			onNext: function() {
				$('#task_filter a.dropdown_menu_all_filters_togl').trigger('click');
			}
		},
		{
			target: 'filterModal',
			title: _('Access Real Data With Smart Filters'),
			content: _('Get straight to the facts with filters on task types, assignee, due dates, status and labels.'),
			placement: 'left',
			//yOffset: -35,
			arrowOffset: 2,
			//multipage : true,
			delay: 1000,
			onNext: function() {
				//window.location = HTTP_ROOT + 'user-role-settings/';
        //$('.row_tr td:nth-child(2) .check-drop-icon .dropdown-toggle').trigger('mouseenter');
        $('#tour_closeTaskFilter').trigger('click');
        
				$('#tour_task_title_listing_act .dropdown-toggle').attr('aria-expanded', true);
				$('#tour_task_title_listing_act .dropdown-toggle').parent().addClass('open');				
				$('#tour_task_title_listing_act .dropdown-toggle').css('visibility','visible');
				$('#tour_task_title_listing_act').css('visibility','visible');
			}
		},
		{
			target: 'tour_task_title_listing_act',
			title: _('All The Actions You Need!'),
			content: _('Take charge of your tasks, update status, type, post replies, copy or delete. All from one small yet powerful actions menu.'),
			placement: 'top',
			yOffset: -1,
			xOffset: -5,
			arrowOffset: 2,
			// multipage : true,
			delay: 2000,
			onNext: function() {
      window.location = HTTP_ROOT + 'dashboard#/calendar';	
       
        // var uid = $('#tour_task_title_listing a').attr('data-task-id');
        // easycase.ajaxCaseDetails(uid, 'case', 0);
				// window.location = HTTP_ROOT + 'dashboard#/details/'+$('#tour_task_title_listing a').attr('data-task-id');				
			},
			
		},
		// {
		// 	target: 'tour_task_detail_sec',
		// 	title: _('All The Information You Need'),
		// 	content: _('Absolute clarity about your tasks – start & due dates, estimated hours, assignee, associated files, detailed descriptions and interactive comments display.'),
		// 	placement: 'bottom',
		// 	xOffset: 315,
		// 	yOffset: -25,
		// 	arrowOffset: 30,
		// 	//multipage : true,
		// 	width: 350,
		// 	delay: 2000,
		// 	onNext: function() {
		// 		//window.location = HTTP_ROOT + 'user-role-settings/';				
		// 	}
		// },
		// {
		// 	target: 'tab-subTask',
		// 	title: _('Rome Wasn’t Built In A Day!'),
		// 	content: _('Break tasks to manageable subtasks & sub-subtasks and assign them to individual members for faster execution. Give your projects a meaningful structure.'),
		// 	placement: 'top',
		// 	yOffset: -5,
		// 	xOffset: -15,
		// 	arrowOffset: 0,
		// 	//multipage : true,
		// 	//delay: 2000,
		// 	onNext: function() {
		// 		//window.location = HTTP_ROOT + 'user-role-settings/';				
    //   },
    //   onShow: function() {
				
		// 	}
		// },
		// {
		// 	target: 'tab-taskLink',
		// 	title: _('Connected Execution'),
		// 	content: _('Interlink tasks within a project to provide a good overview & the reason the tasks exist. All involved have the required info for successful execution.'),
		// 	placement: 'top',
		// 	yOffset: -7,
		// 	arrowOffset: 2,
		// 	//multipage : true,
		// 	//delay: 2000,
		// 	onNext: function() {
		// 		//window.location = HTTP_ROOT + 'user-role-settings/';				
    //   },
    //   onShow: function() {
				
		// 	}
		// },
		// {
		// 	target: 'tab-reminders',
		// 	title: _('No More Delays!'),
		// 	content: _('Set task reminders with meaningful messages and mark the key players. Get notified and act at the right time!'),
		// 	placement: 'top',
		// 	yOffset: -8,
		// 	arrowOffset: 2,
		// 	//multipage : true,
		// 	//delay: 2000,
		// 	onNext: function() {
		// 		//window.location = HTTP_ROOT + 'user-role-settings/';				
    //   },
    //   onShow: function() {
				
		// 	}
		// },
		// {
		// 	target: 'tour_lbl',
		// 	title: _('Define Task Tags'),
		// 	content: _('Custom classify your tasks with Labels to quickly identify key tasks for focused action.'),
		// 	placement: 'top',
		// 	yOffset: -18,
		// 	xOffset: -8,
		// 	arrowOffset: 2,
		// 	//multipage : true,
		// 	delay: 2000,
		// 	onNext: function() {
		// 		window.location = HTTP_ROOT + 'dashboard#/calendar';				
		// 	}
		// },
		{
			target: 'tour_calendar_view_v2',
			title: _('Take Charge Of Your Day!'),
			content: _("Take stock of your team's plan for the day, week & month."),
			placement: 'right',
			//xOffset: 35,
			yOffset: -15,
			//arrowOffset: 32,
			//multipage : true,
			delay: 1000,
			onNext: function() {
				window.location = HTTP_ROOT + 'dashboard#/kanban';				
			}
		},
		{
			target: 'tour_calendar_view_v2',
			title: _('Visual Task Execution'),
			content: _('Conduct efficient status review meetings with the interactive Kanban Board. Never let a task fall through the cracks.'),
			placement: 'right',
			//xOffset: 35,
			yOffset: -15,
			//arrowOffset: 32,
			//multipage : true,
			delay: 1000,
			onNext: function() {
				//window.location = HTTP_ROOT + 'user-role-settings/';				
			}
		},
  ],  
	//onStart: ["tour_role_action"],
  showPrevButton: false,
  scrollTopMargin: 100,
  onStart: function(){
    localStorage.setItem("tour_frm_close",'0');
		$('body').addClass('hopscotch_bubble_body');
  },
	onEnd: function() {
		$('body').removeClass('hopscotch_bubble_body');
		var t_compl = 0;
		localStorage.setItem("tour_type", '0');
		if(localStorage.getItem("tour_frm_close") != '1'){
			if(localStorage.getItem("tour_complete")){
				t_compl = localStorage.getItem("tour_complete");
				if(t_compl.indexOf(3) == -1){
					localStorage.setItem("tour_complete",t_compl+',3');
				}
			}else{
				localStorage.setItem("tour_complete",'3');
			}
		}
		localStorage.setItem("tour_frm_close",'0')
		newOnboarding();
	},
	onClose: function() {
		$('body').removeClass('hopscotch_bubble_body');
		localStorage.setItem("tour_type", '0');
		localStorage.setItem("tour_frm_close",'1');
		if(localStorage.getItem("onboard_is_on") != '1'){
		newOnboarding();
	}
	}
};


//Detail Page
var onbd_tour_deatailpage = {
  id: 'hello-hopscotch',
  steps: [
		{
			target: 'tour_task_detail_sec',
			title: _('Task Title'),
			content: _('Find the Task Title.'),
			placement: 'bottom',
			yOffset: 0,
			arrowOffset: 2,
			onNext: function() {
				$('#tab-overView').trigger('click');
			}
		},
		{
			target: 'tour_taskdetail_description', 
			title: _('Task Description'),
			content: _('FInd task description that was entered at the time of task creation.'),
			placement: 'top',
			arrowOffset: 2,
			onNext: function() {
			
			}
		},
		{
			target: 'tour_taskdetail_comment',
			title: _('Comments'),
			content: _('Add comments on the task and it’s progresses.'),
			placement: 'top',
			yOffset: -9,
      arrowOffset: 2,
			onNext: function() {
        $('#tab-subTask').trigger('click');	
        
			}
    },
    
		{
			target: 'tab-subTask',
			title: _('Task Subtasks'),
			content: _('Find the Subtasks underneath the task.'),
			placement: 'top',
			yOffset: -9,
      arrowOffset: 2,
			onNext: function() {
        $('#tab-timelog').trigger('click');		
			}
    },
    {
			target: 'tab-timelog',
			title: _('Task Timelog'),
			content: _('Find the entered time logs of the task.'),
			placement: 'top',
			yOffset: -9,
      arrowOffset: 2,
			onNext: function() {
      			$('#tab-files').trigger('click');	
			}
    },
    {
			target: 'tab-files',
			title: _('Task Files'),
			content: _('Find the associated files of the tasks, added by the users.'),
			placement: 'top',
			yOffset: -9,
      arrowOffset: 2,
			onNext: function() {
      	$('#tab-bugs').trigger('click');			
			}
    },
    {
			target: 'tab-bugs',
			title: _('Task Bugs'),
			content: _('Find the Bug and Bug-related details underneath the Task.'),
			placement: 'top',
			yOffset: -9,
      arrowOffset: 2,
			onNext: function() {
        $('#tab-integration').trigger('click');		
			}
    },
    {
			target: 'tab-integration',
			title: _('Task Integration'),
			content: _('See the information on integrations like Github, Zoom Meeting, etc.'),
			placement: 'top',
			yOffset: -9,
      arrowOffset: 2,
			onNext: function() {
      				$("#tab-activity").trigger('click');
			}
    },
    {
			target: 'tab-activity',
			title: _('Task Activity'),
			content: _('See the list of task logs or the activities underneath the task.'),
			placement: 'top',
			yOffset: -9,
      arrowOffset: 2,
			onNext: function() {
      			$('#tab-checkList').trigger('click');	
			}
		},
    {
			target: 'tab-checkList',
			title: _('Check List'),
			content: _('Checklist for performing the task that was entered at the time of task creation.'),
			placement: 'top',
			yOffset: -9,
      arrowOffset: 2,
			onNext: function() {
        $("#tab-taskLink").trigger('click');
      				
			}
    },
    {
			target: 'tab-taskLink',
			title: _('Task Links'),
			content: _('Find the tasks that are linked to this task in the list view.'),
			placement: 'top',
			yOffset: -9,
      arrowOffset: 2,
			onNext: function() {
        $("#tab-reminders").trigger('click');      				
			}
    },
    {
			target: 'tab-reminders',
			title: _('Task Reminder'),
			content: _('See the Task Reminders and their message entered by users.'),
			placement: 'top',
			yOffset: -9,
      arrowOffset: 2,
			onNext: function() {
        if($('#timelineSec').hasClass('selected')){

        }else{
        $("#tour_detail_timeline").trigger('click');      				          
        }
      				
			}
    },
    {
			target: 'timelineSec',
			title: _('Task Time Line'),
			content: _('See the task progresses and summary in the task timeline.'),
			placement: 'left',
			// yOffset: -9,
      arrowOffset: 2,
			onNext: function() {
        $("#tour_detail_timeline").trigger('click');      				
        $("#tour_detail_people").trigger('click');      				
      				
			}
    },
    {
			target: 'peopleSec',
			title: _('Task Involved People'),
			content: _('Find the involved people for the particular task.'),
			placement: 'left',
			// yOffset: -9,
      arrowOffset: 2,
			onNext: function() {
        $("#tour_detail_people").trigger('click');      				
        $("#tour_detail_custome").trigger('click'); 
			}
    },
    {
			target: 'customSec',
			title: _('Custom Fields'),
			content: _('Find the additional data of the task in the form of custom fields.'),
			placement: 'left',
			// yOffset: -9,
      arrowOffset: 2,
			onNext: function() {
        $("#tour_detail_custome").trigger('click');    
        if($('#lableSec').hasClass('selected')){
            
        }else{
        // $("#tour_lbl").trigger('click'); 		          
        }  				
			}
    },
    {
			target: 'lableSec',
			title: _('Task Labels'),
			content: _('Find the task labels that are used to categorize tasks.'),
			placement: 'left',
			// yOffset: -9,
      arrowOffset: 2,
			onNext: function() {
      				
			}
		},
  ],  
	//onStart: ["tour_role_action"],
  showPrevButton: false,
  scrollTopMargin: 100,
  onStart: function(){
    localStorage.setItem("tour_frm_close",'0');
		$('body').addClass('hopscotch_bubble_body');
  },
	onEnd: function() {
		$('body').removeClass('hopscotch_bubble_body');
		var t_compl = 0;
		localStorage.setItem("tour_type", '0');
		if(localStorage.getItem("tour_frm_close") != '1'){
			if(localStorage.getItem("tour_complete")){
				t_compl = localStorage.getItem("tour_complete");
				if(t_compl.indexOf(3) == -1){
					localStorage.setItem("tour_complete",t_compl+',3');
				}
			}else{
				localStorage.setItem("tour_complete",'3');
			}
		}
		localStorage.setItem("tour_frm_close",'0')
		// newOnboarding();
	},
	onClose: function() {
		$('body').removeClass('hopscotch_bubble_body');
		localStorage.setItem("tour_type", '0');
		localStorage.setItem("tour_frm_close",'1');
		if(localStorage.getItem("onboard_is_on") != '1'){
		// newOnboarding();
	}
	}
};


//Manage your work
var onbd_tour_tandresrc = {
  id: 'hello-hopscotch',
  /*i18n: {
	nextBtn: "Próxima",
	prevBtn: "De volta",
	doneBtn: "Feito",
	skipBtn: "Feito",
  },*/
  steps: [
		{
			target: 'tour_start_timer',
			title: _('Track Time!'),
			content: _('Easy time tracking for your tasks.'),
			placement: 'left',
			//yOffset: -35,
			arrowOffset: 2,
			//multipage : true,
			delay: 2000,
			onNext: function() {
				localStorage.setItem("tour_type_nxt", '0');
				openTimer();
			}
		},
		{
			target: 'tour_timer_header',
			title: _('Make Your Teams Tick!'),
			content: _('Use the Timer for automatic time tracking so that you focus on real work.'),
			placement: 'right',
			//yOffset: -35,
			arrowOffset: 2,
			//multipage : true,
			delay: 1000,
			onNext: function() {
				checkHashLoad('timelog');
				localStorage.setItem("tour_type_nxt", '1');
				//stopTimer();
				window.location = HTTP_ROOT + 'dashboard#/timelog';
			}
		},
		{
			target: 'tour_tlog_listing',
			title: _('All Your Time Tracking Needs At One Place'),
			content: _('See how your teams have been spending their time across projects in a single view.'),
			placement: 'bottom',
			//yOffset: -35,
			//arrowOffset: 2,
			//multipage : true,
			delay: 2000,
			onNext: function() {
				localStorage.setItem("tour_type_nxt", '1');
				//window.location = HTTP_ROOT + 'dashboard#/chart_timelog';
				window.location = HTTP_ROOT + 'dashboard#/timesheet';
			}
		},
		/*{
			target: 'chart_log_view',
			title: _('Your team\'s Day on a Card!'),
			content: _('Intuitive card view instantly tells you what your team has been up to for that day.'),
			placement: 'top',
			//yOffset: -35,
			arrowOffset: 2,
			//multipage : true,
			delay: 2000,
			onNext: function() {
				window.location = HTTP_ROOT + 'dashboard#/timesheet';
			}
		},*/
		{
			target: 'timesheet_btn_daily',
			title: _('Save Time In No Time!'),
			content: _('Hate time tracking? Use the daily and weekly timesheets to enter time for all your tasks in a single box. Easy in, Easy out!'),
			placement: 'right',
			//yOffset: -35,
			arrowOffset: 2,
			multipage : true,
			delay: 1000,
			onNext: function() {
				localStorage.setItem("tour_type_nxt", '0');
				window.location = HTTP_ROOT + 'resource-availability/';
			}
		},
		{
			target: 'tour_resource_avail',
			title: _('Manage Workload'),
			content: _('Plan your project pipeline, know how much work your team can accommodate & ensure optimum workloads.'),
			placement: 'left',
			//yOffset: -35,
			arrowOffset: 2,
			multipage : true,
			delay: 2000,
			onNext: function() {
				window.location = HTTP_ROOT + 'LogTimes/resource_settings';
			}
		},
		{
			target: 'chat_on_off',
			title: _('Setup Resource Management Parameters'),
			content: _('Define your company holidays, setup your work week and hours per day for smooth resource allocation and management.'),
			placement: 'right',
			yOffset: -25,
			xOffset: 40,
			arrowOffset: 2,
			multipage : true,
			delay: 1000,
			onNext: function() {
				window.location = HTTP_ROOT + 'resource-utilization/';
			}
		},
		{
			target: 'grid-keep-selection',
			title: _('No More Blind Spots!'),
			content: _('Resource Utilization report presents you the true state of affairs. Who, What, When, Where - answered right here. Smart filters make them all a lot easier.'),
			placement: 'top',
			xOffset: 150,
			arrowOffset: 2,
			multipage : true,
			delay: 1000,
			onNext: function() {
				window.location = HTTP_ROOT + 'project_reports/dashboard';
			},
			onShow: function() {				
			}
		},
		{
			target: 'tour_report_link',
			title: _('From Data To Insightful Decisions!'),
			content: _('Projects, Tasks, Time & Resources – Track their performance & understand the state of your business. Identify what needs your attention!'),
			placement: 'top',
      xOffset: 225,
      yOffset: 285,
			//multipage : true,
			delay: 1000,
			onNext: function() {
				//$('#task_filter a.dropdown_menu_all_filters_togl').trigger('click');
			},
			onShow: function() {				
        $('#ui-accordion-accordion-1-header-1').trigger('click');			
			}
		},
  ], 
	//onStart: ["tour_role_action"],
  showPrevButton: false,
  scrollTopMargin: 100,
  onStart: function(){
    localStorage.setItem("tour_frm_close",'0');
		$('body').addClass('hopscotch_bubble_body');
  },
	onEnd: function() {
		$('body').removeClass('hopscotch_bubble_body');
		var t_compl = 0;
		localStorage.setItem("tour_type", '0');
		if(localStorage.getItem("tour_frm_close") != '1'){
			if(localStorage.getItem("tour_complete")){
				t_compl = localStorage.getItem("tour_complete");
				if(t_compl.indexOf(4) == -1){
					localStorage.setItem("tour_complete",t_compl+',4');
				}
			}else{
				localStorage.setItem("tour_complete",'4');
			}
		}
		localStorage.setItem("tour_frm_close",'0');
    newOnboarding();
	},
	onClose: function() {
		$('body').removeClass('hopscotch_bubble_body');
		localStorage.setItem("tour_type", '0');
		localStorage.setItem("tour_frm_close",'1');
		if(localStorage.getItem("onboard_is_on") != '1'){
		newOnboarding();
	}
	}
};

/*-----Portugees end here-----*/


if(LANG_PREFIX == '_spa'){
  var GBl_tour = tour_spa;
}else if(LANG_PREFIX == '_deu'){
  var GBl_tour = tour_deu;
}else if(LANG_PREFIX == '_fra'){
  var GBl_tour = tour_fra;
}else if(LANG_PREFIX == '_por'){
  var GBl_tour = tour_por;
}else{
  var GBl_tour = tour;
}

/* ========== */
/* TOUR SETUP */
/* ========== */
addClickListener = function(el, fn) {
  if (el.addEventListener) {
    el.addEventListener('click', fn, false);
  }
  else {
    el.attachEvent('onclick', fn);
  }
},
init = function() {
  var startBtnId = 'startTourBtn',
      calloutId = 'startTourCallout',
      mgr = hopscotch.getCalloutManager(),
      state = hopscotch.getState();
  if (state && state.indexOf('hello-hopscotch:') === 0 && (CONTROLLER != 'Roles' && CONTROLLER !='project_reports' && CONTROLLER !='easycases') && (PAGE_NAME != 'resource_availability' && PAGE_NAME != 'resource_settings' && PAGE_NAME != 'resource_utilization')) {
    // Already started the tour at some point!
		if(localStorage.getItem("tour_type") == '0'){
			hopscotch.startTour(GBl_tour);
		}
  } else {
    // Looking at the page for the first(?) time.
   /* setTimeout(function() {
      mgr.createCallout({
        id: calloutId,
        target: startBtnId,
        placement: 'right',
        title: 'Take an example tour',
        content: 'Start by taking an example tour to see Juggernaut Cart in action!',
        yOffset: -25,
        arrowOffset: 20,
        width: 240
      });
    }, 100);*/
  }
	if($('#startBtnId').length){
		addClickListener(document.getElementById(startBtnId), function() {
			if (!hopscotch.isActive) {
				mgr.removeAllCallouts();
				hopscotch.startTour(GBl_tour);
			}
		});
	}
};
$(document).ready(function(){
  init();
})

//hopscotch.startTour(tour_crttask);