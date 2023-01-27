# CSS Guidelines

* Sections should be defined in CSS by follow a rule whereby each section who is a child of the body should be named by a comment above the start of the first CSS rule applying to said child. 
* Children of those child items who are children of the body should be indented according to their respective nesting in the HTML document.

## For Example:
```
/* Start about-us */

.about-us {
    ...
}
    .submit-button-container {
        ...
        .submit-button {
            ...
        }
    }
```
