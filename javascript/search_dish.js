/*----------------DISH-----------------*/
const searchDishes = document.querySelector('#search')
if (searchDishes) {
  
  searchDishes.addEventListener('input', async function() {
    const response = await fetch('../api/api_dishes.php?search=' + this.value)
    const dishes = await response.json()

    const section = document.querySelector('#dishes')
    section.innerHTML = ''

    console.log(dishes)
    console.log(dishes.lenght)

    for (var i = 0; i < dishes.length; i += 2) {

        const div = document.createElement('div')
        div.classList.add('dish_column')

        article = drawDish(dishes[i])
        div.appendChild(article)
        
        if(dishes[i+1]){
          article = drawDish(dishes[i+1])
          div.appendChild(article)
        }
        
        section.appendChild(div)
    }
  })
}

function drawDish(dish){
    const article = document.createElement('article')
    article.classList.add('dish')

    const anchor_img = document.createElement('a')
    anchor_img.href = 'dish.php?id=' + dish.id

    const img = document.createElement('img')
    img.src = dish.photo;

    anchor_img.appendChild(img)

    const div_info = document.createElement('div')
    div_info.classList.add('info')

    const dish_name = document.createElement('span')
    dish_name.classList.add('dish_name')
    dish_name.textContent = dish.name_

    const div_spacer = document.createElement('div')
    div_spacer.classList.add('spacer')

    const dish_price = document.createElement('span')
    dish_price.classList.add('dish_price')
    dish_price.textContent = dish.price

    const dish_evaluation = document.createElement('span')
    dish_evaluation.classList.add('dish_evaluation')

    const star = document.createElement('i')
    star.setAttribute('class', 'fa fa-star')
    star.setAttribute('aria-hidden', 'true')

    dish_evaluation.appendChild(star.cloneNode(true))
    dish_evaluation.append(dish.rating)

    div_spacer.appendChild(dish_price)
    div_spacer.appendChild(dish_evaluation)

    div_info.appendChild(dish_name)
    div_info.appendChild(div_spacer)

    article.appendChild(anchor_img)
    article.appendChild(div_info)
  
    return article;
}