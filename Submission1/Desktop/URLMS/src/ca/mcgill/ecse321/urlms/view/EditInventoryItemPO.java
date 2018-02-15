package ca.mcgill.ecse321.urlms.view;

import java.awt.BorderLayout;
import java.awt.EventQueue;

import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.border.EmptyBorder;

import ca.mcgill.ecse321.urlms.controller.InvalidInputException;
import ca.mcgill.ecse321.urlms.controller.InventoryController;
import ca.mcgill.ecse321.urlms.controller.StaffController;

import javax.swing.GroupLayout;
import javax.swing.GroupLayout.Alignment;
import javax.swing.JTextField;
import javax.swing.JButton;
import java.awt.event.ActionListener;
import java.awt.event.ActionEvent;
import javax.swing.JLabel;
import javax.swing.LayoutStyle.ComponentPlacement;
import javax.swing.JScrollPane;

public class EditInventoryItemPO extends JFrame {

	private JPanel contentPane;
	private JTextField txtOldItemName;
	private JTextField txtItemCost;
	public static InventoryController controller = new InventoryController();
	private JButton btnDelete;
	private JTextField txtQuantity;
	private JLabel lblItemName;
	private JLabel lblItemCost;
	private JLabel lblQuantity;
	private JTextField txtItemCategory;
	private String error;
	private JButton btnAdd;
	private JLabel lblItemCategory;
	private JButton btnClose;
	private JLabel lblError;
	private JLabel lblNewName;
	private JTextField txtNewItemName;


	/**
	 * Create the frame.
	 */
	public EditInventoryItemPO() {
		initComponents();
	}
	
	private void initComponents(){
		setResizable(false);
		setAlwaysOnTop(true);
		setTitle("Edit Inventory Item");
		setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
		setBounds(100, 100, 566, 320);
		contentPane = new JPanel();
		contentPane.setBorder(new EmptyBorder(5, 5, 5, 5));
		setContentPane(contentPane);
		
		txtOldItemName = new JTextField();
		txtOldItemName.setColumns(10);
		
		txtItemCost = new JTextField();
		txtItemCost.setColumns(10);
		
		btnAdd = new JButton("Edit Inventory Item");
		btnAdd.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				error = "";
				
				try {
					String oldName = txtOldItemName.getText();
					String newName = txtNewItemName.getText();
					double cost = Double.valueOf(txtItemCost.getText());
					String category = txtItemCategory.getText();
					int quantity;
					String quantityText = txtQuantity.getText();
					if (quantityText.isEmpty()) {
						quantity = Integer.MIN_VALUE;
					}
					else{
						quantity = Integer.valueOf(quantityText);
					}
					
					controller.editInventoryItemDetails(oldName, newName, category, cost, quantity);
				} catch (InvalidInputException e1) {
					error += e1.getMessage();
				} catch (NumberFormatException e1) {
					error += "Please enter a valid cost (double) and/or quantity (integer) amount. ";
				} catch (RuntimeException e1) {
					error += "stuff happened. ";
				}
				refreshData();
				
			}
		});
		
		btnDelete = new JButton("Delete Targeted Inventory Item");
		btnDelete.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				error = "";
				
				try {
					String name = txtOldItemName.getText();
					
					controller.removeInventoryItembyName(name);
				} catch (InvalidInputException e1) {
					error += e1.getMessage();
				} catch (RuntimeException e1) {
					error += "stuff happened. ";
				}
				refreshData();
			}
		});
		
		txtQuantity = new JTextField();
		txtQuantity.setColumns(10);
		
		lblItemName = new JLabel("Item Name (case-sensive) | Old:");
		
		lblItemCost = new JLabel("New Item Cost (CAD, use '.' for floating point):");
		
		lblQuantity = new JLabel("Updated Quantity (leave empty if editing equipment):");
		
		txtItemCategory = new JTextField();
		txtItemCategory.setColumns(10);
		
		lblItemCategory = new JLabel("New Item Category (e.g. Computer, Chair):");
		
		btnClose = new JButton("Close");
		btnClose.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				close();
			}
		});
		
		JScrollPane scrollPane = new JScrollPane();
		
		lblNewName = new JLabel("New:");
		
		txtNewItemName = new JTextField();
		txtNewItemName.setColumns(10);
		GroupLayout gl_contentPane = new GroupLayout(contentPane);
		gl_contentPane.setHorizontalGroup(
			gl_contentPane.createParallelGroup(Alignment.LEADING)
				.addGroup(gl_contentPane.createSequentialGroup()
					.addGroup(gl_contentPane.createParallelGroup(Alignment.LEADING)
						.addGroup(gl_contentPane.createSequentialGroup()
							.addGap(14)
							.addComponent(btnAdd)
							.addGap(18)
							.addComponent(btnDelete)
							.addGap(17)
							.addComponent(btnClose))
						.addGroup(gl_contentPane.createSequentialGroup()
							.addGap(47)
							.addComponent(scrollPane, GroupLayout.PREFERRED_SIZE, 466, GroupLayout.PREFERRED_SIZE)))
					.addContainerGap())
				.addGroup(gl_contentPane.createSequentialGroup()
					.addGap(11)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.LEADING)
						.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
							.addComponent(lblItemName)
							.addGap(3)
							.addComponent(txtOldItemName, 0, 86, Short.MAX_VALUE)
							.addGap(18)
							.addComponent(lblNewName, GroupLayout.PREFERRED_SIZE, 42, GroupLayout.PREFERRED_SIZE)
							.addPreferredGap(ComponentPlacement.RELATED)
							.addComponent(txtNewItemName, GroupLayout.PREFERRED_SIZE, 135, GroupLayout.PREFERRED_SIZE))
						.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
							.addComponent(lblQuantity)
							.addPreferredGap(ComponentPlacement.RELATED)
							.addComponent(txtQuantity, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE))
						.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
							.addComponent(lblItemCost)
							.addPreferredGap(ComponentPlacement.RELATED)
							.addComponent(txtItemCost, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE))
						.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
							.addComponent(lblItemCategory)
							.addPreferredGap(ComponentPlacement.RELATED)
							.addComponent(txtItemCategory, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)))
					.addGap(11))
		);
		gl_contentPane.setVerticalGroup(
			gl_contentPane.createParallelGroup(Alignment.TRAILING)
				.addGroup(gl_contentPane.createSequentialGroup()
					.addContainerGap(23, Short.MAX_VALUE)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(txtOldItemName, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
						.addComponent(lblItemName)
						.addComponent(lblNewName)
						.addComponent(txtNewItemName, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE))
					.addPreferredGap(ComponentPlacement.RELATED)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(txtItemCategory, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
						.addComponent(lblItemCategory))
					.addPreferredGap(ComponentPlacement.RELATED)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(txtItemCost, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
						.addComponent(lblItemCost))
					.addPreferredGap(ComponentPlacement.RELATED)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(txtQuantity, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
						.addComponent(lblQuantity))
					.addGap(10)
					.addComponent(scrollPane, GroupLayout.PREFERRED_SIZE, 45, GroupLayout.PREFERRED_SIZE)
					.addGap(11)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(btnAdd)
						.addComponent(btnClose)
						.addComponent(btnDelete))
					.addGap(21))
		);
		
		lblError = new JLabel("Feel free to edit some inventory items.");
		scrollPane.setViewportView(lblError);
		contentPane.setLayout(gl_contentPane);
	}
	
	private void refreshData(){
		if(error.length() > 0){
			lblError.setText(error);
		}
		else{
			lblError.setText("Requested inventory changes successfully made.");
		}
	}
	
	public void close() { 
		this.setVisible(false);
	    this.dispose();
	}
}
