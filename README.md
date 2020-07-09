#### How to **get started**:

1. Clone this **branch**
2. Run `$ composer install`
3. Everything you need is in the **src** directory

#### How to show us your results:
1. Push your results to your private repo
2. Give access to maurice@proxify.io and vlad@proxify.io

#### What you should show us:
1. Clean and readable code
2. Good knowledge in design patterns
3. Reusable code fragments

#### The main task in this assignment:
Create a function, that makes an external call to an api and chain it with helper functions

#### 🤖 Instructions:
1. Call the class `Caller`:
    ```php
       $caller = new Caller;
    ```

2. Make a http request to an api:
     ```php
       $caller->make('https://api.github.com/users', 'get');
     ```
3. Find the root of the items (You can exclude this function, if the items are already at the root position):
    ```php
      $caller->root('data.users');
      ```
4. Filter elements by their value [boolean, integer and string] (This function can be excluded or used several times):
    ```php
      $caller->where('site_admin','=', false);
      ```
5. Sort elements by their value (This function can be excluded or used several times):
    ```php
      $caller->sort('name', 'DESC');
      ```
6. Get the array:
    ```php
      $caller->get(); or $caller->only(['name']);
      ```
   
    Example output: 
    
    ```json
         [
           {
             "login": "mojombo",
             "id": 1,
             "node_id": "MDQ6VXNlcjE=",
             "avatar_url": "https://avatars0.githubusercontent.com/u/1?v=4",
             "gravatar_id": "",
             "url": "https://api.github.com/users/mojombo",
             "html_url": "https://github.com/mojombo",
             "followers_url": "https://api.github.com/users/mojombo/followers",
             "following_url": "https://api.github.com/users/mojombo/following{/other_user}",
             "gists_url": "https://api.github.com/users/mojombo/gists{/gist_id}",
             "starred_url": "https://api.github.com/users/mojombo/starred{/owner}{/repo}",
             "subscriptions_url": "https://api.github.com/users/mojombo/subscriptions",
             "organizations_url": "https://api.github.com/users/mojombo/orgs",
             "repos_url": "https://api.github.com/users/mojombo/repos",
             "events_url": "https://api.github.com/users/mojombo/events{/privacy}",
             "received_events_url": "https://api.github.com/users/mojombo/received_events",
             "type": "User",
             "site_admin": false
           },
           {
             "login": "defunkt",
             "id": 2,
             "node_id": "MDQ6VXNlcjI=",
             "avatar_url": "https://avatars0.githubusercontent.com/u/2?v=4",
             "gravatar_id": "",
             "url": "https://api.github.com/users/defunkt",
             "html_url": "https://github.com/defunkt",
             "followers_url": "https://api.github.com/users/defunkt/followers",
             "following_url": "https://api.github.com/users/defunkt/following{/other_user}",
             "gists_url": "https://api.github.com/users/defunkt/gists{/gist_id}",
             "starred_url": "https://api.github.com/users/defunkt/starred{/owner}{/repo}",
             "subscriptions_url": "https://api.github.com/users/defunkt/subscriptions",
             "organizations_url": "https://api.github.com/users/defunkt/orgs",
             "repos_url": "https://api.github.com/users/defunkt/repos",
             "events_url": "https://api.github.com/users/defunkt/events{/privacy}",
             "received_events_url": "https://api.github.com/users/defunkt/received_events",
             "type": "User",
             "site_admin": false
           }
       ]
      ```
   

