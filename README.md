## About the api

For both solutions, im using pagination traits in order to filter or sort out the list. The pagination is based on my previous [project](https://gitlab.com/azuddin/megazine/-/blob/master/app/Traits/Pagination.php). It work corresponding to the key/field that available in db. Also the key can be scale up (\*which means having ability to only allow set of keys that can be filter/sort). Also in order to have multiple sorting/filtering, im using arrayed params:

-   pageSize
-   page
-   sorted[0][id]
-   sorted[0][desc]
-   filtered[0][id]
-   filtered[0][value]

Below are the sample endpoint answering question 1 & 2:

-   post list order by number of comment: **/api/posts?sorted[0][id]=num_of_comments&sorted[0][desc]=true**

-   comment list filter by post: **/api/comments/filtered[0][id]=post_id&filtered[0][value]=1**

Also attached postman collection [here](tribehired.postman_collection.json).
