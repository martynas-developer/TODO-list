import React from 'react';
import {Link, useParams} from "react-router-dom";
import useFetch from "../utils/useFetch";

const TodoDetails = () => {
    const { id } = useParams();
    const { data: todo, error, isLoading } = useFetch('/api/tasks/' + id);

    return (
        <div className="container">
            <div className="row justify-content-center">

                <div className="col-5">
                    {error && <div>{ error }</div>}
                    {isLoading && <div>Loading...</div>}
                    {todo &&
                        <>
                            <blockquote className="blockquote text-center">
                                <p className="mb-0">{ todo.description }</p>
                                {todo.completedAt && <footer className="blockquote-footer">completed at: { todo.completedAt }</footer>}
                                {!todo.completedAt && <footer className="blockquote-footer">uncompleted yet :/</footer>}
                            </blockquote>
                            <Link to={`/todos/${todo.id}/edit`}>
                                <button className="btn btn-primary btn-block">Edit</button>
                            </Link>
                        </>
                    }
                </div>
            </div>
        </div>
    );
}

export default TodoDetails
