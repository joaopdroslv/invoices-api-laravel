# Laravel API for Invoice Management

This is a simple Laravel-based API designed for managing invoices and users. It allows users to perform CRUD operations on invoices, retrieve user information, and filter invoices based on query parameters.

## Features

- **User Management**: Retrieve a list of users and specific user details.
- **Invoice Management**: Perform CRUD operations on invoices.
- **Filtering**: Filter invoices using query parameters for specific searches.

## API Routes

The API is versioned under `v1`. Below are the available routes:

### User Routes

- **GET** `/api/v1/users`  
  Retrieve a list of users.
  
- **GET** `/api/v1/users/{user}`  
  Retrieve details of a specific user by their ID.

### Invoice Routes

- **GET** `/api/v1/invoices`  
  Retrieve a list of invoices. Supports query parameters for filtering.
  
- **GET** `/api/v1/invoices/{invoice}`  
  Retrieve details of a specific invoice by its ID.
  
- **POST** `/api/v1/invoices`  
  Create a new invoice.
  
- **PUT** `/api/v1/invoices/{invoice}`  
  Update an existing invoice by its ID.
  
- **DELETE** `/api/v1/invoices/{invoice}`  
  Delete an existing invoice by its ID.

### Query Parameters for Invoice Filtering

You can filter invoices by passing query parameters in the `GET /api/v1/invoices` request. The filters support different operators and can be used to narrow down the results.

#### Available Operators

- **eq**: Equals (`=`)
- **gt**: Greater than (`>`)
- **gte**: Greater than or equal (`>=`)
- **lt**: Less than (`<`)
- **lte**: Less than or equal (`<=`)
- **ne**: Not equal (`!=`)
- **in**: In a set of values (`IN`)

#### Example Queries

- **/api/v1/invoices?paid[eq]=1**  
  Retrieves invoices where the `paid` field is equal to `1`.

- **/api/v1/invoices?value[gt]=90000**  
  Retrieves invoices where the `value` field is greater than `90000`.

- **/api/v1/invoices?type[in]=[c]**  
  Retrieves invoices where the `type` is one of the values in the array `['c']`.

- **/api/v1/invoices?paid[eq]=1&value[gt]=90000&type[in]=[c]**  
  Retrieves invoices where:
  - `paid` equals `1`
  - `value` is greater than `90000`
  - `type` is `c`

#### Query Parameter Syntax

- Query parameters are passed in the format:  
  `{field}[operator]={value}`  
  For example, `paid[eq]=1` checks for invoices where the `paid` field equals `1`.
  
- If the operator is `in`, the value should be an array of items enclosed in square brackets:  
  `type[in]=[c,d,e]`.