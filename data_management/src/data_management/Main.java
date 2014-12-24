package data_management;

import server_management.Server_Socket;



/**
 *
 * @author programming
 */
public class Main {

    public static void main(String[] args) {
        java.awt.EventQueue.invokeLater(new Runnable() {

            public void run() {
                Server_Socket ss = new Server_Socket();
                //while(true){
                ss.run();
                //}
            }
        });
    }
}
