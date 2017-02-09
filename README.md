Chalk1Up
========
### A climbing app for serious climbers

# About
Chalk1Up is an app for logging, analyzing, and sharing your climbing stats. For the most part, the app relies on crowd sourcing for routes to be kept up-to-date in the system. We are working on gaining gym participation with the app, in which case setters would maintain the routes in the app. We aim to keep the app free for climbers, while gyms would pay monthly for the service, as it would improve their route setting/stripping workflow and give them valuable insight into climber's opinions of the routes and the gym.

# Details
## App
The app has three portals: climb, set, and desktop. Right now, only the climb portal is implemented to a satisfactory degree. The setter portal is partially implemented.

## Technologies
### Server
PHP, Slim (routing and light-weight MVC framework)
### View
JQueryMobile, D3JS for graphs, Google Maps for mapping
### Data
MySQL. I would like to look into best practices for data modeling in PHP

# Tasks
## Ross's Todo List
### Routing + Frameworks
- [x] Install and setup Slim
- [x] Document Slim
- [x] Get basic routing demo to work (Gyms - routing branch commit 9a35530)
- [x] Setup routing for all the pages
- [ ] Rewrite URL so "public" doesn't show
- [x] Investigate templating tools (Twig for ex)
   - [ ] Create the templates it makes sense to create
- [x] SSL Encrypt the site (chalk1up.net, climb., set., app., dev.)
- [ ] Investigate MV* frameworks (Knockout.js, Backbone.js)
   - [ ] Implement demo framework
   - [ ] Implement framework throughout app
- [ ] Slim settings.php for controlling which database we're connected to
- [ ] Port code into MVC framework

- [ ] Database migrations?
- [ ] Better authentication tool? (Zend_Auth for ex)
- [ ] Encrypted cookies

### Climber Portal
- [ ] Blue theme
- [ ] Fix brown theme with graphs


### Setter Portal
- [ ] Should it actually be a separate portal?
      * We could just add a couple URI's and make the UX clearly demarcate setter vs climber behaviors
         * `/gyms/:gymid/setters`
         * `/gyms/:gymid/forerun`
- [ ] Better/quicker set workflow
- [ ] Suggest color tape to use (i.e. avoid repeated colors in an area and of a given grade)
- [ ] Setter stats
- [ ] Route stats
- [ ] Weekly email report
- [ ] Administration page
      * Allow gym manager / head setter to manage who are setters, etc...
      * Set list of tape colors
      * Climber audit (i.e. time and length, # routes, etc...)
      * Adjust climbers' permissions at your gym
         * Can climbers add/edit/strip routes?
         * (Meh) Action approval mechanism? I.e. climber makes route, but gym needs to approve it
- [ ] See climber comments (attached to routes or aggregated?)

### Desktop 
- [ ] Pick a UI tool (JQueryUI? Responsive JQM?)
- [ ] Replicate climber + setter behavior


## Cody's Todo List
### Git
- [ ] Git setup with Cygwin (or Msysgit)
- [ ] Read this [viral article about branching](http://nvie.com/posts/a-successful-git-branching-model/)
- [ ] DON'T develop on Master branch

### Workouts
- [ ] Beta test
- [ ] Streamline the workflow
- [ ] Confirm they work for ropes as well

## Joint Todo
### Testing
- [ ] Investigate best way to integrate PHPUnit with our new MVC framework
- [ ] Install and setup PHPUnit
- [ ] Setup test database
- [ ] Test models
- [ ] Test controllers
      * Are they getting the appropriate data?
      * Do the HTTP methods behave properly?)
- [ ] Test javascript (Selenium?)

### Continuous Integration
- [ ] Investigate free / really cheap build tools (Jenkins? Codeship.io?)
- [ ] Get build running on each commit
- [ ] Get build running all tests
- [ ] Build report code coverage
- [ ] Build automatically deploy?

### Accolades
- [ ] I don't think they are being assigned properly
- [ ] Make a more robust Accolade model (table) and ensure idempotency

### Climber Points (i.e. the # in the upper left of profile)
- [ ] Improve the points system - new climbers start with ~111 pts somehow
