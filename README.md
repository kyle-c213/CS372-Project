<p align="center">
  <img src="project/public/images/szlogo.png" alt="SZ Logo"/>
</p>

# Student Zone
Student Zone is a social media platform designed to cater to the needs of students. Serving as a social and educational hub for students, Student Zone aims to provide students with easy means of communication and connectivity with their classmates.
# Motivation
The motivation for this project is to give university students an all in one social media platform for all things related to university. It will give students easier access to buy and sell textbooks, meet new people, and get help with classes. Most students at one time or another have had a class where they do not understand a subject or a question, but if you do not know anyone in the class and can not make the professor's office hours this can make it difficult to get help. With our social media platform, it will be much easier to find other people in the class to help each other with studying. 
# Features
<h3>Classes</h3>
  The core of the site is centered around classes. Classes are set up by users where students can join and discuss anything related to the class. Students can make posts to receive help on assignments from their fellow classmates, or to clear up any confusion related to course content. In addition, students can mark important dates for things like exams, assignments, and project due dates.
<h3>ToDo</h3>
  Each student is given access to their own to do list. Here they can keep track of any tasks they wish to enter.
<h3>Message Center</h3>
  Making use of Chatify and Pusher in conjunction with Laravel's broadcasting and event features, the message center allows for users to send and receive messages in real time.
<h3>Professor Rating System</h3>
  To start students can search and select a professor to rate or view. If a professor is not found then the student can enter the professors information (name and faculty) to be added to the database. Once added, the student will be redirected to the professor's ratings page. Students can rate and comment on professors depending on their experiences and if they recommend them or not. A rating out of 5 can be given to a professor and an average rating based on all of the reviews will be calculated. Students can also view current ratings with the associated comments for that professor. 
<h3>Buy & Sell</h3>
  Students can posts anything from textbooks to a tutoring service they provide for sale. Other students can look at the listings and contact the seller through a built in messaging system. All messaging is done through the site itself.

# Tech/Framework Used
<b>Built with:</b>
<ul>
  <li><a href="project/README.md">Laravel 8.x</a></li>
</ul>
<b>Languages:</b>
<ul>
  <li>PHP</li>
  <li>Blade</li>
  <li>Javascript</li>
</ul>
<b>Various Libraries</b>
<ul>
  <li><a href="https://jquery.com/">JQuery</a></li>
  <li><a href="https://getbootstrap.com/">Bootstrap</a></li>
</ul>
<b>Database</b>
<ul>
  <li>MySQL</li>
</ul>
<b>Other External Resources</b>
<ul>
  <li><a href="https://github.com/munafio/chatify/blob/master/README.md">Chatify</a></li>
  <li><a href="https://pusher.com/">Pusher</a></li>
  <li><a href="https://fontawesome.com/">Font Awesome</a></li>
</ul>

# Project Setup
<ol>
  <li>Clone the repository (git clone &lt;repository&gt;)</li>
  <li><a href="https://www.apachefriends.org/index.html">Download XAMPP</a> (make sure to include phpMyAdmin) or another web server of your choice.</li>
  <li><a href="https://getcomposer.org/download/">Download composer</a></li>
  <li><a href="https://nodejs.org/en/">Download nodejs</a></li>
  <li>Run cp .env.example .env and configure your .env file to match your database.</li>
  <li>
    In the terminal, navigate to the project directory and run the following commands:
    <ul>
      <li>composer global require laravel/installer</li>
      <li>composer install</li>
      <li>npm install</li>
      <li>php artisan storage:link</li>
      <li>php artisan key:generate</li>
    </ul>
  <li>
    Build & run the project
    <ul>
      <li>npm run dev (or npm run watch)</li>
      <li>php artisan serve</li>
      <li>Navigate to localhost:8000 (default) in your browser</li>
    </ul>
  </li>
  </li>
</ol>

