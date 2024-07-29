import { useLocation, Link } from 'react-router-dom'

export default function HeaderComponent() {

    const location = useLocation();

    const isListPage = () => {
        switch (location.pathname) {
            case '/':
            case '/list-products':
                document.title = "Product List";
                return true;
            case '/add-product':
                document.title = "Product Add";
                return false;
            default:
                document.title = "Page Not Found";
                return true;
        }
    };
    return (
        <header>
            <div className="navbar mt-3">
                <div className="container">
                    <div className="navbar-brand">

                        {isListPage() && <Link to="/"><h2>Product List </h2> </Link>}
                        {!isListPage() && <Link to="/add-product"><h2>Product Add </h2> </Link>}
                    </div>
                    <div className="navbar-right">
                        {isListPage() && (
                            <>
                                <Link className="btn btn-primary shadow-sm me-5" to="/add-product"> ADD </Link>
                                <button name="delete_product" type="submit" id="delete-product-btn" className="btn btn-danger shadow-sm" form="delete_form">MASS DELETE</button>
                            </>
                        )
                        }
                        {!isListPage() && (
                            <>
                                <button name="add_product" type="submit" className="btn btn-success shadow-sm me-4" form="product_form">Save</button>
                                <Link className="btn btn-danger shadow-sm" to="/"> Cancel </Link>
                            </>
                        )
                        }
                    </div>
                </div>
            </div>
        </header>
    )
}