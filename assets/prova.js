const {useState} = require("react");
const React = require("react");
const { Rating } = require('react-simple-star-rating');

let ReactDOM = require('react-dom');


// ES6 React.Component doesn't auto bind methods to itself. You need to bind them yourself in constructor.
// https://stackoverflow.com/questions/33973648/react-this-is-undefined-inside-a-component-function

class StarRating extends React.Component {

    constructor(props) {
        super(props);
        this.state = {rating: 0};
    }

    handleRating(rate) {

        let jsonRating = { value: rate, movie: this.props.movie, user: this.props.user};
        fetch('/api/rating', {method: 'POST',
            body: JSON.stringify(jsonRating)}) // 1
            .then(response => response.json()) // 2
            .then(data=> {
                console.log(data.value);
                this.setState({rating: data.value}); // 3
            })
        // quan canvia el rating caldrà guardar les dades
        // this.setState({rating: rating})
    }

    componentDidMount() {
        // quan es munten els components caldrà actualitzar les dades amb la .

        let movie = this.props.movie;
        let user = this.props.user;

        fetch('/api/rating/' + movie + '/' + user) // 1
            .then(response => response.json()) // 2
            .then(data=> {
                console.log(data.value);
                this.setState({rating: data.value}); // 3
            })
    }

    render() {
        return <div className="card-footer"><Rating onClick={(rate) => this.handleRating(rate)} ratingValue={this.state.rating}/></div>;
    }
}

document.addEventListener('DOMContentLoaded',
    function (e) {
        let movies = document.querySelectorAll('.movie');

        for (let i=0; i< movies.length; i=i+1) {
            let movie = movies[i];
//            console.log(movie.dataset);
//            ReactDOM.render(
//                <StarRating movie={movie.dataset.movieId} />,
//                movie.appendChild(document.createElement('div')));
            ReactDOM.render(<StarRating movie={movie.dataset.movieId} user={movie.dataset.userId} />, movie.appendChild(document.createElement('div')));
        }
    }
)
