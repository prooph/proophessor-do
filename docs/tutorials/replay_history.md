# Replay History

In this tutorial you'll explore the **history replay** feature of prooph/event-store.

## Create Some History

We assume you have proophessor-do up and running. Just create some todos, add deadlines and mark some of them as done.
The app will record all your actions in form of domain events like `TodoWasPosted` or `DeadlineWasAddedToTodo`.
Also projections will store the current state in read model tables so that the view pages of proophessor-do can
show statistics about open and closed todos and list all todos of a user.

Take one or two screenshots as we are going to delete all data now!

## Read Models Are Throw Away Data

Throw away data means it can be deleted at any time. Let's do exactly this. Open your favorite database management tool,
select the proophessor-do schema and *truncate the read_\* tables*:

```sql
TRUNCATE TABLE read_user;
TRUNCATE TABLE read_todo;
```

Refresh the user page in proophessor-do (/user-list). It should tell you that no user is registered.
Damn, all data is lost, isn't it?

## Replay History Events

No, the data is not lost. We still have all recorded events in the event stream. We just need to load them from the
event store in correct order and pass them to the read model projectors again.
The good news is proophessor-do ships with a simple replay script. You only need to run `php scripts/history_replay.php`
from a terminal and everything will look like before.

Now you know how replay magic works. And as you can see it is not a complex beast but a powerful feature.
Imagine you want to add a new view to the application showing some more statistics, for example the average of time needed to close a todo.
You would just need to add a new projection and replay all events to fill the view with data you already have.
How cool is that?

This is the end of our replay history tutorial. We hope you enjoyed it and learned something new.
Feedback is welcome: [![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/prooph/improoph)

your prooph team
