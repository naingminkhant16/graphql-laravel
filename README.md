# GraphQL APIs in Laravel

This repo is example of developing GraphQL APIs in Laravel using LightHouse and JWT for authentication.

### User's Query

```bash
query GetUserWithArticles {
  user(id:12) {
    id
    email
    name
    articles{
        id
        title
        body
        published
        published_at
    }
  }
}

query GetAllUsers{
    users{
        id
        name
        email
    }
}

query GetAuthUser{
    me{
        id
        name
        email
    }
}


```

### User's Mutation

```bash
mutation {
    registerUser(input:{
        name:"Test1",
        email:"test1@gmail.com",
        password:"password"
    }){
        id
        name
        email
    }
}

mutation {
    login(input:{
        email:"test@gmail.com",
        password:"password"
    }){
        access_token
        token_type
        expires_in
        user {
            id
            name
            email
        }
    }
}

mutation {
    logout 
}


```

### Article's Mutation

```bash
mutation {
    createArticle(input:{
        title:"What is GraphQL?"
        body: "Et voluptatem reprehenderit animi qui cupiditate culpa. Iste beatae nobis et vero et. Sequi sequi rem aut quia eos."
    }){
        id
        title
        body
        slug
        author {
            id 
            name
        }
        published
        published_at 
    }
}
```

