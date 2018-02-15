package com.example.team8.urlms;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.Toast;

import java.util.List;

import ca.mcgill.ecse321.urlms.application.URLMSApplication;
import ca.mcgill.ecse321.urlms.controller.Controller;
import ca.mcgill.ecse321.urlms.controller.InventoryController;
import ca.mcgill.ecse321.urlms.controller.StaffController;
import ca.mcgill.ecse321.urlms.model.InventoryItem;
import ca.mcgill.ecse321.urlms.model.URLMS;

public class InventoryListPage extends AppCompatActivity {

    private URLMS urlms;
    private String fileName;
    Controller controller = new Controller();
    InventoryController ic = new InventoryController();

    Button backButton;
    Button refreshButton;
    ListAdapter viewItemAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_inventory_list_page);
        //load controller and model
        fileName = getFilesDir().getAbsolutePath() + "/urlms.xml";
        URLMSApplication.setFilename(fileName);
        urlms = URLMSApplication.getURLMS();

        Bundle b =this.getIntent().getExtras();
        final String[] inventoryList = b.getStringArray("data");

        List<InventoryItem> ii = ic.viewInventoryList();
        final String[] inventoryItems= new String[ii.size()];

        for(int i =0; i<ii.size(); i++){
            inventoryItems[i]= "Item: " + ic.viewInventoryItemName(i)+"\n" +
                    "Cost: " +ic.viewInventoryItemCost(i)+"\n";
            if(ic.inventoryItemIsEquipment(i)) {
                inventoryItems[i]+= "Type: Equipment ";
            }else {
                inventoryItems[i]+="Type: Supply " +"\n" + "Quantity: " + ic.viewSupplyItemQuantity(i);
            }
        }


       viewItemAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, inventoryItems);
        ListView buckyListView = (ListView) findViewById(R.id.buckyListView);
        buckyListView.setAdapter(viewItemAdapter);


        buckyListView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Toast myToast= Toast.makeText(getApplicationContext(),"You have clicked on "
                        +ic.viewInventoryItemName(position)+".",Toast.LENGTH_SHORT);
                myToast.show();
                ic.save();
                Intent intent = new Intent(getApplicationContext(),InventoryItemPage.class );
                intent.putExtra("itemPosition", position);
                finish();
                startActivity(intent);
            }
        });

        backButton = (Button) findViewById(R.id.backButton);
        refreshButton = (Button) findViewById(R.id.refreshButton);
        setBackButton();
        setRefreshButton();
    }


    //button methods
    public void setBackButton(){
        backButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {ic.save();
                finish();
            }
        });
    }
    public void startActivity(Class<?> cls){
        ic.save();
        Intent intent = new Intent(this,cls );
        startActivity(intent);
        finish();
    }
    public void setRefreshButton(){
        refreshButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                toastMessage("Refreshed.");
                recreate();
            }
        });

    }
    public void toastMessage(String message){
        Toast myToast= Toast.makeText(getApplicationContext(),message,Toast.LENGTH_SHORT);
        myToast.show();
    }
}
