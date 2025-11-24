<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthGuard implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // CHECK: Is the user logged in?
        // We set 'logged_in' => TRUE in the Auth Controller earlier.
        if (!$session->get('logged_in')) {
            // If they are NOT logged in, redirect them to the login page immediately.
            return redirect()->to('/login')->with('msg', 'You must log in to view this page.');
        }

        // ROLE CHECK (Optional but Recommended)
        // If you want to strictly prevent Faculty from accessing Admin URLs here
        // instead of in the Controller, you can add logic like this:
        /*
        $uri = service('uri');
        if ($uri->getSegment(1) == 'admin' && $session->get('role') == 'faculty') {
            return redirect()->to('/faculty/dashboard');
        }
        */
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // We don't need to do anything after the page loads, so we leave this empty.
    }
}