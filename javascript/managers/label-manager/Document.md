# **LabelManager**

```plaintext
[]: # Author: Suleiman Jaber
[]: # Last Update: December 28 2022        
[]: # Version: 1.0
```

---

## About

`LabelManager` is a concept of code that makes it easier for developers to manage labels in their project,
This can be accomplished by creating object for each label, And since all labels will share the same methods you will
just have to control the object which will control the label for you.

------

## How Does It Work ?

`LabelManager` is very simple, it takes a few parameters upon creating the manager object, and it contains some useful
methods you can use such as (set text...etc).

You can basically import your label object into your script and start managing it without the need to use `document.querySelector`.

On each method you call, `LabelManager` will look for your label in the DOM and modify it.

Please note that if you try to create manager object for label that cannot be found in the DOM you will get an error message

------

## How To Use ?

Here is an example of how to use `LabelManager`.

First, You'll have to create a new file for your label.

Please note that you'll need to pass label parent id and label id:

| Parameter | Description                | Type   | Required |
|-----------|----------------------------|--------|----------|
| _parentId | The parent id of the label | string |     ✓    |
| _id       | The id of the label        | string |     ✓    |

```javascript
// File: label_test.js
import LabelManager from '/javascript/helpers/handlers/labels/LabelManager.js';

const parentId = 'mainDivId'
const id = 'myLabelId'

export default new LabelManager(parentId, id)
```

Second, You can import this file in your script and start working on it.

```javascript
// File: init.js
import label_test from './labels/label_test.js'

// Change label text to 'New Label'
label_test.setText('New Label')
```

------

## Methods

| Method      | Description                                                     | Takes  | Return  |
|-------------|-----------------------------------------------------------------|--------|---------|
| doesExist() | Check if the element exists in the DOM by the IDs you've passed | -      | boolean |
| setText()   | Set the label's text                                            | string |         |