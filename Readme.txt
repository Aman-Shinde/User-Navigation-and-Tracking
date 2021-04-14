User Navigation and Tracking

dataflow:-

				 index.html
				     |
				process.php
				 /        \
			users.php       admin.php
		       /	\
		process1.php  process2.php


Database structure :-

				tracking (database)
				/		\
			   users		user

	users:- 	ID	 :- Primary key
			Email_ID :- User's email stored in this cloumn
			Password :- Password of the user stored in this coloumn
			Role 	 :- Role of user stored in this coloumn
	(we are using users table for multiuser login in same page we check the role of the user and accordingly redirect user to concern page)


	user:-     ID	     :- Primary key
		   Email_ID  :-	User's email stored in this cloumn
		   Latitude  :-	Latitude of user's location stored in this coloumn
		   Longitude :- Longitude of user's location stored in this coloumn
		   Timestamp :- Updated timestamp of user's location stored in this coloumn
	(we are using a user table to store user's location and time stamp)
	
Login credentials :-

	For user:-
				Email_ID :- user1@gmail.com
				Password :- q1w2e3r4
						
				Email_ID :- user2@gmail.com
				Password :- q1w2e3r4
			
	For admin:-
				Email_ID :- admin@gmail.com
				Password :- q1w2e3r4
						
Working :-
	
	For Navigation :-
	
					User have to enter valid address and click on getroute button
					it will redirect to another page user can see trip started from his
					location to change or update the user's location user have to press refresh button.
	
	For Tracking :-
					
					Admin can easily check users updated location on admin.php
					to update admin have to click refresh button. 
					Pressing on user's marker admin can able to see user's Email_ID and the updated timestamp.
						
IMP Note:-

	Don't forget to add your google api key in 
					line no.92 of users.php,
					line no.143 of process2.php,
					line no.93 of admin.php.
			
						
						
 
