## Contributing

Thanks for wanting to contribute to Orangescrum!

### Where do I go from here?

So you want to contribute to Orangescrum? Great!

If you have noticed a bug, please  [create an issue](https://github.com/Orangescrum/orangescrum/issues)  for it before starting any work on a pull request.

After the bug is validated or the feature is accepted by a project maintainer, the next step is to fork the repository!

### Fork & create a branch

If there is something you want to fix or add, the first step is to fork this repository.

Next is to create a new branch with an appropriate name. The general format that should be used is

```
git checkout -b '<type>/<description>'

```

The  `type`  is the same as the  `type`  that you will use for  [your commit message](https://github.com/Orangescrum/orangescrum/issues).

The  `description`  is a decriptive summary of the change the PR will make.

### General Rules

-   All PRs should be rebased (with master) and commits squashed prior to the final merge process
-   One PR per fix or feature
- Do the require changes to add some features or plug-ins on your local system
- Do proper testing(including UI) and make sure that the changes are working properly
```
```

### Unwanted PRs

-   Please do not submit pull requests containing only typo fixes, fixed spelling mistakes, or minor wording changes.

### Git Commit Message Style

This project uses the  [conventional commits](https://www.conventionalcommits.org/en/v1.0.0/#summary)  format.

Example commit messages:

```
chore: update gqlgen dependency to v2.6.0
docs(README): add new contributing section
fix: remove debug log statements
```
