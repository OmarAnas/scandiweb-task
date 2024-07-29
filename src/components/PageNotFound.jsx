import { Link } from "react-router-dom";

export default function PageNotFound() {
    return (
        <div className='not-found-container bg-body-tertiary'>
            <div>
                <h1> 404 </h1>
                <p> The page you're looking for is not found. </p>
                <Link className="btn btn-primary shadow-sm" to="/"> Go Home </Link>
            </div>
        </div>
    )
}