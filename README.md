# PHP Midterm API – Quotes, Authors, Categories

Ericka Brown  
Deployed API: https://php-midterm-api2.onrender.com

This project is a RESTful API built for the PHP Midterm. It connects to a PostgreSQL database hosted on Render and returns JSON data for quotes, authors, and categories. The API supports filtering by author, filtering by category, and returning a random quote.

---

## Features

- PostgreSQL database with three related tables
- Clean JSON output
- Filter quotes by author_id
- Filter quotes by category_id
- Random quote option
- Deployed on Render
- MVC-style structure (config → models → api)

---

## Database Schema

### authors
- id (SERIAL, primary key)
- author (VARCHAR)

### categories
- id (SERIAL, primary key)
- category (VARCHAR)

### quotes
- id (SERIAL, primary key)
- quote (TEXT)
- author_id (INT, foreign key → authors.id)
- category_id (INT, foreign key → categories.id)

---

## Endpoints

### Get all authors
GET /api/authors/

Example:[ {"id":1,"author":"Albert Einstein"}, {"id":2,"author":"Mark Twain"} ]

### Get all categories
GET /api/categories/

Example:[ {"id":1,"category":"Inspiration"}, {"id":2,"category":"Life"} ]

### Get all quotes
GET /api/quotes/

Example:[ { "id": 1, "quote": "Life is like riding a bicycle. To keep your balance, you must keep moving.", "author": "Albert Einstein", "category": "Inspiration" } ]

---

## Query Parameters

Filter by author: 
/api/quotes/?author_id=1

Filter by category:
/api/quotes/?category_id=3

Random quote:
/api/quotes/?random=true

Combined filters:
/api/quotes/?author_id=1&category_id=1

---

## Technologies Used

- PHP
- PostgreSQL
- Render (hosting)
- GitHub (version control)

---

## Project Structure
/config Database.php
/models Authors.php Categories.php Quotes.php
/api /authors index.php /categories index.php /quotes index.php

---

## Notes

- All endpoints return JSON only.
- Database is hosted on Render.
- Filtering and random quote logic are implemented in the Quotes model.
- This project fulfills the requirements for the PHP Midterm API assignment.





