const nickname = localStorage.getItem("nickname");
const base_url = document.body.dataset.baseurl;
const blogs_div = document.querySelector(".blogs");
const currentUserId = localStorage.getItem("user_id");

function timeSince(date) {

    var seconds = Math.floor((new Date() - date) / 1000);
  
    var interval = seconds / 31536000;
  
    if (interval > 1) {
      return Math.floor(interval) + " years";
    }
    interval = seconds / 2592000;
    if (interval > 1) {
      return Math.floor(interval) + " months";
    }
    interval = seconds / 86400;
    if (interval > 1) {
      return Math.floor(interval) + " days";
    }
    interval = seconds / 3600;
    if (interval > 1) {
      return Math.floor(interval) + " hours";
    }
    interval = seconds / 60;
    if (interval > 1) {
      return Math.floor(interval) + " minutes";
    }
    return Math.floor(seconds) + " seconds";
  }

function getBlogs(){
    axios.get(`${base_url}/api/blog/list.php?nickname=${nickname}`).then(res=>{
        showBlogs(res.data);
    })
}
getBlogs()

function showBlogs(blogs){
    let divHTML = '';
    if(blogs.length == 0){
        blogs_div.innerHTML = "<h1>0 blogs</h1>";
    }

    for(let i in blogs){
        let dropdown = ""
        if(currentUserId==blogs[i]["authore_id"]){
            dropdown = `<span class="link">
            <img src="images/dots.svg" alt="">
            Еще
            <ul class="dropdown">
                <li> <a href="${base_url}/editblog.php?id=${blogs[i]['id']}>">Редактировать</a> </li>
                <li><a href="${base_url}/api/blog/delete.php?id=${blogs[i]['id']}>" class="danger">Удалить</a></li>
            </ul>
        </span>`
        }
        divHTML += `
        <div class="blog-item">
            <img class="blog-item--img" src="${base_url}/${blogs[i]['img']}" alt="">
            <div class="blog-header">
                <h3>${blogs[i]['title']}</h3>

                ${dropdown}
        
        </div>
        <p class="blog-desc">
        ${blogs[i]["description"]}
        </p>
        
        <div class="blog-info">
            <span class="link">
                <img src="images/date.svg" alt="">
                ${timeSince(Date.parse(blogs[i]["date"]))}
                <!-- to_time_ago показывает как давно загрузился файл -->
            </span>
            <span class="link">
                <img src="images/visibility.svg" alt="">
                21
            </span>
            <a class="link">
                <img src="images/message.svg" alt="">
                4
            </a>
            <span class="link">
                <img src="images/forums.svg" alt="">
                ${blogs[i]["name"]}
            </span>
            <a class="link">
                <img src="images/person.svg" alt="">
                ${blogs[i]["nickname"]}
            </a>
            </div>
        </div>
        
        `;
    }
    blogs_div.innerHTML = divHTML
}

 
