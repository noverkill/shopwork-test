# Shopworks Recruitment Test

Thank you for taking the time to do our technical test. It consists of two parts:

- [A coding test](#coding-test)
- [A few technical questions](#technical-questions)

To submit your solution and answers, please upload a repository to GitHub, GitLab or whatever code hosting platform you prefer - Please *do not* send us back a zip file !

**Please ensure that it also contains a single markdown file with answers to the technical questions.**

## Coding Test

Our product provides tools for managers to plan staff schedules (rotas), __one week at a time (Monday to Sunday)__. 

Let's call our shop __FunHouse__. 

Staff who are employed to work at __FunHouse__ are __Black Widow__, __Thor__, __Wolverine__, __Gamora__.

### Overall project scope: single manning calculation for FunHouse

>>>
As a shop manager

I want to know how many **single manning minutes** there were in my shop **each day of this week**

So that I can calculate how much bonus I'll pay out daily. 
>>>

#### Why this scope is important?

Staff get paid an enhanced _bonus_ supplement when they are working alone in the shop. Shop managers can use the information gathered above to strategically plan new rotas in the future with less single manning hours, reducing the cost of running that shop.


#### Scenario One

>>>
```
Black Widow: |----------------------|
```

__Given__ Black Widow working at FunHouse on Monday in one long shift

__When__ no-one else works during the day

__Then__ Black Widow receives single manning supplement for the whole duration of her shift. 
>>>

#### Scenario Two

>>>
```
Black Widow: |----------|
Thor:                   |-------------|
```

__Given__ Black Widow and Thor working at FunHouse on Tuesday

__When__ they only meet at the door to say hi and bye

__Then__ Black Widow receives single manning supplement for the whole duration of her shift

__And__ Thor also receives single manning supplement for the whole duration of his shift.
>>>

#### Scenario Three

>>>
```
Wolverine: |------------|
Gamora:       |-----------------|
```

__Given__ Wolverine and Gamora working at FunHouse on Wednesday

__When__ Wolverine works in the morning shift

__And__ Gamora works the whole day, starting slightly later than Wolverine

__Then__ Wolverine receives single manning supplement until Gamorra starts her shift

__And__ Gamorra receives single manning supplement starting when Wolverine has finished his shift, until the end of the day.
>>>

### Task requirements

Your task is to **implement a class** that receives a `Rota` and returns `SingleManning`, a DTO (Data Transfer Object) containing the __number of minutes worked alone in the shop each day of the week__.

You'll find a `migration.php` file attached, which is a standard Laravel migration file describing the data structure - ** you do not need to implement this migration or models as part of the code test. They are just for reference**

Please ensure your code is easily readable.

There is no time limit to complete the task, but make sure that the following criteria is met:

1. Make sure that all the above scenarios would work.
2. Include tests if you have been asked to.
3. We would like for you to **describe in *Given When Then* and provide a test (if you have been asked to) ** for another scenario. (You do not need to implement a solution for it, just tell us if your current class would handle the solution or not)
4. Please only include the files absolutely necessary to complete the task. **We do not wish to see a full application - please spend your time on the logic of the class and your code style.**

## Technical Questions

Please answer the following questions in a markdown file called `Answers to technical questions.md`.

1. How long did you spend on the coding test? What would you add to your solution if you had more time?
2. Why did you choose PHP as your main programming language?
3. What is your favourite thing about your most familar PHP framework (Laravel / Symfony etc)? 
4. What is your least favourite thing about the above framework?
