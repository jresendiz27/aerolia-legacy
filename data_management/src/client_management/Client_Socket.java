package client_management;

/**
 *
 * @author Alberto
 */
import data_management.EolikContent;
import data_management.HistoryContent;
import data_management.Security;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.net.Socket;
import java.net.UnknownHostException;
import java.util.ArrayList;
import javax.crypto.SealedObject;

public class Client_Socket {

    Socket requestSocket;
    ObjectOutputStream out;
    ObjectInputStream in;
    Object message;
    SealedObject obj = null;

    public Client_Socket() {
    }

    public boolean run(Object data, int type) {
        try {
            //1. creating a socket to connect to the server
            requestSocket = new Socket("localhost", 2004);
            System.out.println("Connected to localhost in port 2004");
            //2. get Input and Output streams
            out = new ObjectOutputStream(requestSocket.getOutputStream());
            out.flush();
            in = new ObjectInputStream(requestSocket.getInputStream());
            //3: Communicating with the server
            try {
                message = (Object) in.readObject();
                switch (type) {
                    case 1:
                        obj = Security.encryptArrayContent((ArrayList<EolikContent>) data);
                        break;
                    case 2:
                        obj = Security.encrypArraytLog((ArrayList<HistoryContent>) data);
                        break;
                    case 3:
                        obj = Security.encryptObjectContent((EolikContent) data);
                        break;
                    case 4:
                        obj = Security.encrypObjecttLog((HistoryContent) data);
                        break;
                }
                System.out.println("DES process...");                
                sendObject(obj, type);
            } catch (ClassNotFoundException classNot) {
                System.err.println("data received in unknown format");
                return false;
            }
            close();
            if (message.toString().equals("OK")) {
                return true;
            } else {
                return false;
            }
        } catch (UnknownHostException unknownHost) {
            System.err.println("You are trying to connect to an unknown host!");
            close();
            return false;
        } catch (IOException ioException) {
            close();
            return false;
        }
    }

    public void sendObject(SealedObject ob, int type) {
        try {
            out.writeObject(ob);
            out.writeObject(type);
            out.flush();
            //System.out.println("client->" + ob);
        } catch (Exception ioException) {
            ioException.printStackTrace();
        }
    }

    public void close() {
        try {
            in.close();
            out.close();
            requestSocket.close();
        } catch (IOException ioException) {
            //ioException.printStackTrace();
        }
    }
}
