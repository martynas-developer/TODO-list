import React from 'react';
import {Link} from "react-router-dom";

const NavBar = () => {
    return (
        <>
            {localStorage.token &&
            <nav className="navbar navbar-expand-lg navbar-light bg-light">
                <Link to="/" className="navbar-brand">
                    Home
                </Link>
                <div className="navbar-nav">
                    <Link to="/todos" className="nav-item nav-link">
                        Create todo
                    </Link>
                </div>
            </nav>
            }
            {!localStorage.token &&
            <nav className="navbar navbar-expand-lg navbar-light bg-light">
                <div className="navbar-nav">
                    <Link to="/login" className="nav-item nav-link">Login</Link>
                    <Link to="/register" className="nav-item nav-link">Register</Link>
                </div>
            </nav>
            }
        </>
    )
}

export default NavBar;