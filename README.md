Symfony Blog test
=================

Requirements
------------
* What I need to see here is a page where the posts are seen without being logged on (index). 
* Pagination is not necessary at this point. So the list of post shown has NO limit.
* Once there is a post, it will be click-able in some fashion, I suggest the post title as is usually seen everywhere. 
  That will redirect to the page with the post and a textarea to add a comment. 
* Under the textarea, there will be a list of previous comments, ordered by date desc. 
* That list is also infinite, meaning that there is no limit to the amount of comments seen.
* A page where, once logged on, you can add a new post; this page needs to have a text area for text 
  but also a link/field/button (depending on what you use to upload) to add a picture. 
* This picture has to be saved somewhere under the blog's folders.
* You can have the login as a popup from a link or a stand-alone page, either accessible as a link or semi-secret 
  like the wordpress /wp-admin one.
* The database should consist of only a few tables. We're not going to go crazy on this side just for a simple test. 
* So a table `user`, `post` and `comment` would be enough for the goal of this task. 
* If you want to go ahead and have a `log` table to record logins and posting/editing of posts, that would be fine as well.
* We wont be testing your knowledge of url rewriting either, so the posts will be accessed simply by their id, ie: blogurl/?id=25
* All inputs needs to be checked for XSS/CSRF (you might want to brush up on CSRF attacks) and other types of attacks or forgery. This is a requirement for everyone to know exactly why and how to protect against those.
* Please make your website in HTML5 with graceful degradation for browsers that do not support it and please please please test your site in Internet Explorer 7, 8, 9, 10, Firefox, Chrome and Opera (to name a few). Full use of jQuery is expected as well (ie: forms pre-verification/validation).


References
----------

[**Symblog**][1]

[1]: http://tutorial.symblog.co.uk/
