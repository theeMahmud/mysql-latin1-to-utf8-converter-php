# Charset Converter

This project contains a spellbinding PHP script that converts a MySQL database with a `latin1` charset to `utf8`. It's perfect for those pesky legacy projects with extensive Unicode characters that have been stored improperly due to the `latin1` charset.

## Problem

Recently, I encountered a legacy project with a MySQL charset of `latin1`. The project had extensive Unicode characters, but as the charset was `latin1`, the characters stored in the database appeared as garbled text.

## Solution

I concocted a PHP script to transfigure the `latin1` charset to `utf8`, and as if by magic, all the Unicode characters were displayed perfectly in both the database and the application.

## How to Use

To run the converter, simply execute the following command:

```bash
php converter.php

## TODO

This converter only works for all the tables and columns for the connected database, the plan is to make it customizable so that custom table or column input would work and to make it workable with most of the databases.