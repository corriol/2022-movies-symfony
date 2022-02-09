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

// ES6 React.Component doesn't auto bind methods to itself. You need to bind them yourself in constructor.
// https://stackoverflow.com/questions/33973648/react-this-is-undefined-inside-a-component-function

class StarRating extends React.Component {

    constructor(props) {
        super(props);
        this.state = {rating: 0};
    }

    handleRating(rating ) {
        // quan canvia el rating caldrà guardar les dades
        this.setState({rating: rating})
    }

    componentDidMount() {
        // quan es munten els components caldrà actualitzar les dades amb la .
        //console.log(this);
        this.setState({rating: Math.random() * 100});
    }

    render() {
        return <div className="card-footer"><Rating onClick={() => this.handleRating()} ratingValue={this.state.rating}/></div>;
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
