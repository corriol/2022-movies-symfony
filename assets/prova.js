const {useState} = require("react");
const React = require("react");
const { Rating } = require('react-simple-star-rating');
//const Rating = require('react-simple-star-rating');
let ReactDOM = require('react-dom');



class ShoppingList extends React.Component {
    render() {
        return (
            <div className="shopping-list">
                <h1>Shopping List for {this.props.name}</h1>
                <ul>
                    <li>Instagram</li>
                    <li>WhatsApp</li>
                    <li>Oculus</li>
                </ul>
            </div>
        );
    }
}



const element = React.createElement(
    'h1',
    {className: 'greeting'},
    'Hello, world!'
);

ReactDOM.render(element, document.getElementById('root'));

ReactDOM.render(
    <h1>Hello, world!</h1>,
    document.getElementById('root')
);

class Welcome extends React.Component {
    render() {
        return <h1>Hello, {this.props.name}</h1>;
    }
}

const shopping = <ShoppingList name="Mark" />;

/* ReactDOM.render(
    shopping,
    document.getElementById('root')
); */


const movie = React.createElement(
    'h3',
    {className: 'greeting'},
    'Hello, world!'
);

class StarRating extends React.Component {
    constructor(props) {
        super(props);
        this.state = {rating: 0};
    }

    handleRating(rating) {
        this.setState({rating: rating})
    }

    componentDidMount() {
        // comprovem si ha votat l'usuari i quina és la seua valoració
    }

    render() {
        // Catch Rating value

        //let movies = this.select();
        //for (let i=0; i< movies.length; i=i+1) {
         //   let moviesDiv = movies[i];
        return <div className="card-footer"><Rating/></div>;
        //return <h1>Hello, {this.props.movie}</h1>;
        //return <Rating onClick={this.handleRating} ratingValue={this.state.rating} /* Available Props */ />;

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
            ReactDOM.render(<StarRating movie={movie.dataset.movieId} />, movie.appendChild(document.createElement('div')));
        }
    }
)
