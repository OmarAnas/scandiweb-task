import { BrowserRouter, Routes, Route } from 'react-router-dom'
import ProductAdd from "./ProductAdd"
import ProductList from "./ProductList"
import HeaderComponent from "./HeaderComponent"
import FooterComponent from "./FooterComponent"
import PageNotFound from './PageNotFound'

export default function Main() {
    return (
        <div className="main">
            <BrowserRouter>
                <HeaderComponent />
                <Routes>
                    <Route path='/' element={<ProductList />}></Route>
                    <Route path='/list-products' element={<ProductList />}></Route>

                    <Route path='/add-product' element={<ProductAdd />}></Route>

                    <Route path='*' element={<PageNotFound />}></Route>
                </Routes>
                <FooterComponent />
            </BrowserRouter>
        </div>
    )
}




