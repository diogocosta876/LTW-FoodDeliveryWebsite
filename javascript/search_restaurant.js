/*----------------RESTAURANT-----------------*/

const searchRestaurants = document.querySelector('#search')
if (searchRestaurants) {
  
  searchRestaurants.addEventListener('input', async function() {
    const response = await fetch('../api/api_restaurants.php?search=' + this.value)
    const restaurants = await response.json()

    const section = document.querySelector('#restaurants')
    section.innerHTML = ''

    for (const restaurant of restaurants) {
      const anchor = document.createElement('a')
      anchor.classList.add('restaurant_clickbox')
      anchor.href = 'restaurant.php?id=' + restaurant.id

      const article = document.createElement('article')
      article.classList.add('restaurant')

      const img = document.createElement('img')
      img.src = restaurant.photo;

      const div = document.createElement('div')
      div.classList.add('info')

      const span1 = document.createElement('span')
      span1.classList.add('restaurant_name')
      span1.textContent = restaurant.name
      
      const span2 = document.createElement('span')
      span2.classList.add('restaurant_evaluation')
      span2.textContent = restaurant.rating

      const star = document.createElement('i')
      star.setAttribute('class', 'fa fa-star')
      star.setAttribute('aria-hidden', 'true')

      for(let i = 0; i < 4; i++){
          span2.appendChild(star.cloneNode(true))
      }

      const span3 = document.createElement('span')
      span3.classList.add('restaurant_distance')

      const car = document.createElement('i')
      car.setAttribute('class', 'fa fa-car')
      car.setAttribute('aria-hidden', 'true')
      span3.appendChild(car)

      span3.append(restaurant.address)

      div.appendChild(span1)
      div.appendChild(span2)
      div.appendChild(span3)

      article.appendChild(img)
      article.appendChild(div)

      anchor.append(article)

      section.appendChild(anchor)
    }
  })
}

