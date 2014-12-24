package server_management;

import data_management.EolikContent;
import data_management.FileManager;
import data_management.HistoryContent;
import data_management.Security;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.crypto.SealedObject;

/**
 *
 * @author Alberto
 */
public class Server_Socket {

    ServerSocket providerSocket;
    Socket connection = null;
    ObjectOutputStream out;
    ObjectInputStream in;
    SealedObject receive;
    int receive2;
    ArrayList<EolikContent> aec = null;
    ArrayList<HistoryContent> ahc = null;
    EolikContent ec = new EolikContent();
    HistoryContent hc = new HistoryContent();

    public Server_Socket() {
    }

    public void run() {
        try {
            //1. creating a server socket
            providerSocket = new ServerSocket(2004, 10);
            //2. Wait for connection
            System.out.println("Waiting for connection");
            connection = providerSocket.accept();
            System.out.println("Connection received from " + connection.getInetAddress().getHostName());
            //3. get Input and Output streams
            out = new ObjectOutputStream(connection.getOutputStream());
            out.flush();
            in = new ObjectInputStream(connection.getInputStream());
            sendObject((Object) "Connection successful.Waiting for data");
            db_management.connect();
            //4. The two parts communicate via the input and output streams
            do {
                try {
                    receive = (SealedObject) in.readObject();
                    //System.out.println(receive);
                    receive2 = (Integer) in.readObject();
                    //System.out.println(receive2);
                    switch (receive2) {
                        case 1:
                            aec=Security.decryptArrayContent(receive);
                            System.out.println(aec);
                            if(!db_management.insertContentArray(aec)){
                                FileManager.saveData(aec);
                                sendObject((Object) "OK");
                            }
                            break;
                        case 2:
                            ahc=Security.decryptArrayLog(receive);
                            System.out.println(ahc);
                            if(!db_management.insertLogArray(ahc)){
                                FileManager.saveLog(ahc);
                                sendObject((Object) "OK");
                            }
                            break;
                        case 3:
                            ec=Security.decryptObjectContent(receive);
                            System.out.println(ec);
                            if(!db_management.insertContentObject(ec)){
                                FileManager.saveData(ec);
                                sendObject((Object) "OK");
                            }
                            break;
                        case 4:
                            hc=Security.decryptObjectLog(receive);
                            System.out.println(hc);
                            if(!db_management.insertLogObject(hc)){
                            FileManager.saveLog(hc);
                            sendObject((Object)("OK"));
                            }
                            break;
                    }
                    //System.out.println("data received" + receive);
                    //FileManager.saveData((ArrayList<EolikContent>)receive);
                    System.out.println("data saved");
                    close();
                    run();
                    
                } catch (InterruptedException ex) {
                } catch (ClassNotFoundException classnot) {
                    sendObject((Object) "BAD");
                    System.err.println("Data received in unknown format");
                }
            } while (!receive.toString().equals("OK"));
        } catch (IOException ioException) {
            //ioException.printStackTrace();
        } finally {
            //4: Closing connection
            try {
                in.close();
                out.close();
                providerSocket.close();
            } catch (IOException ioException) {
                //ioException.printStackTrace();
            }
        }
    }

    public void sendObject(Object ob) {
        try {
            out.writeObject(ob);
            out.flush();
            //System.out.println("client->" + ob);
        } catch (IOException ioException) {
            //ioException.printStackTrace();
        }
    }
    public void close(){
        try {
            providerSocket.close();
            in.close();
            out.close();
            connection.close();
        } catch (Exception ex) {
            ex.printStackTrace();
        }
    }
}
