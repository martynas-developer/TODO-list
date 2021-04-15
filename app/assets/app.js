import './styles/app.css';

import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Route, Switch, Link } from "react-router-dom";
import Home from './components/Home';
import Login from "./components/Login";
import TodoDetails from "./components/TodoDetails";
import TodoCreate from "./components/TodoCreate";
import PageNotFound from "./components/PageNotFound";
import Register from "./components/Register";

ReactDOM.render(
    <Router>
        <Link to="/">Home</Link><br/>
        <Link to="/login">Login</Link><br/>
        <Link to="/todos">create</Link>
        <Switch>
            <Route exact path="/">
                <Home />
            </Route>
            <Route path="/register">
                <Register />
            </Route>
            <Route path="/login">
                <Login />
            </Route>
            <Route exact path="/todos">
                <TodoCreate />
            </Route>
            <Route path="/todos/:id">
                <TodoDetails />
            </Route>
            <Route path="*">
                <PageNotFound />
            </Route>
        </Switch>
    </Router>,
    document.getElementById('root')
);
