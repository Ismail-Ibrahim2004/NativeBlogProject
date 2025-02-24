create schema if not exists blog;
use blog;

create table if not exists users(
    `id` int primary key auto_increment,
    `name` varchar(255) not null,
    `email` varchar(255) not null unique,
    `password` varchar(45) not null,
    `phone` varchar(15) unique,
    `created_at` TIMESTAMP default current_timestamp,
    `updated_at` TIMESTAMP default current_timestamp
);

create table if not exists posts(
    `id` int primary key auto_increment,
    `title` varchar(255) not null,
    `content` text,
    `image` varchar(255),
    `user_id` int,
    constraint fk_user_id_users
        foreign key (user_id)
        references users(id)
        on delete cascade
        on update cascade
);

create table if not exists comments(
    `id` int primary key auto_increment,
    `comment` text,
    `created_at` TIMESTAMP default current_timestamp,
    `updated_at` TIMESTAMP default current_timestamp,
    `post_id` int,
    `user_id` int,
    constraint fk_post_id_posts
        foreign key (post_id)
        references posts(id)
        on delete cascade
        on update cascade,
    constraint fk_user_id_comments_users
        foreign key (user_id)
        references users(id)
        on delete cascade
        on update cascade
);

use blog1;

alter table users
add column role enum('subscriber','Admin') default 'subscriber' after phone;


alter table users
drop column role;

